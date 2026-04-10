<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CoursePurchase;
use App\Models\Enrolment;
use App\Models\ModuleProgress;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::published()->withCount('modules');

        // Filter by free/paid
        if ($request->filled('pricing')) {
            if ($request->pricing === 'free') {
                $query->free();
            } elseif ($request->pricing === 'paid') {
                $query->paid();
            }
        }

        // Filter by CPD
        if ($request->boolean('cpd_only')) {
            $query->where('cpd_accredited', true);
        }

        $courses = $query->latest()->paginate(12);

        // Get user's enrolments
        $userEnrolments = [];
        if (auth()->check()) {
            $userEnrolments = Enrolment::where('user_id', auth()->id())
                ->pluck('progress_percentage', 'course_id')
                ->toArray();
        }

        return view('pages.training.index', compact('courses', 'userEnrolments'));
    }

    public function show(string $slug): View
    {
        $course = Course::published()
            ->where('slug', $slug)
            ->with('modules')
            ->firstOrFail();

        $user = auth()->user();
        $enrolment = null;
        $hasAccess = false;
        $moduleProgress = [];

        if ($user) {
            $enrolment = Enrolment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            $hasAccess = $course->isAccessibleBy($user);

            if ($enrolment) {
                $moduleProgress = ModuleProgress::where('enrolment_id', $enrolment->id)
                    ->pluck('status', 'module_id')
                    ->toArray();
            }
        }

        return view('pages.training.show', compact(
            'course',
            'enrolment',
            'hasAccess',
            'moduleProgress'
        ));
    }

    public function enrol(Request $request, string $slug)
    {
        $course = Course::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $user = auth()->user();

        // Check if already enrolled
        $existing = Enrolment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return redirect()->route('training.show', $course->slug)
                ->with('info', 'You are already enrolled in this course.');
        }

        // If paid course, redirect to purchase flow
        if (!$course->is_free && $course->price > 0) {
            // Check if already purchased
            $purchased = CoursePurchase::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', 'completed')
                ->exists();

            if (!$purchased) {
                return redirect()->route('training.purchase', $course->slug);
            }
        }

        // Create enrolment
        Enrolment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);

        $course->increment('enrolments_count');

        return redirect()->route('training.show', $course->slug)
            ->with('success', 'You have been enrolled in this course.');
    }

    public function module(string $courseSlug, string $moduleId): View
    {
        $course = Course::published()
            ->where('slug', $courseSlug)
            ->with('modules')
            ->firstOrFail();

        $module = $course->modules->firstWhere('id', $moduleId);

        if (! $module) {
            abort(404);
        }

        $user = auth()->user();

        // Check access
        if (!$course->isAccessibleBy($user)) {
            abort(403, 'You do not have access to this course.');
        }

        // Get or create enrolment
        $enrolment = Enrolment::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['status' => 'enrolled', 'enrolled_at' => now()]
        );

        // Get or create module progress
        $progress = ModuleProgress::firstOrCreate(
            ['enrolment_id' => $enrolment->id, 'module_id' => $module->id],
            ['status' => 'not_started']
        );

        // Start progress if not started
        if ($progress->status === 'not_started') {
            $progress->start();
        }

        $nextModule = $module->getNextModule();
        $prevModule = $module->getPreviousModule();
        $moduleIndex = $course->modules->search(fn ($m) => $m->id === $module->id);
        $isCompleted = $progress->status === 'completed';

        return view('pages.training.module', compact(
            'course',
            'module',
            'progress',
            'enrolment',
            'nextModule',
            'prevModule',
            'moduleIndex',
            'isCompleted'
        ));
    }

    public function purchase(Request $request, string $slug)
    {
        $course = Course::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $user = auth()->user();

        if ($course->is_free || $course->price <= 0) {
            return redirect()->route('training.show', $course->slug);
        }

        // Check if already purchased
        $purchased = CoursePurchase::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->exists();

        if ($purchased) {
            return redirect()->route('training.show', $course->slug)
                ->with('info', 'You have already purchased this course.');
        }

        $stripeService = app(StripeService::class);
        $session = $stripeService->createCourseCheckout($user, $course);

        return redirect($session->url);
    }

    public function purchaseSuccess(Request $request, string $slug): View
    {
        $course = Course::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.training.show', [
            'course' => $course->load('modules'),
            'enrolment' => Enrolment::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->first(),
            'hasAccess' => $course->isAccessibleBy(auth()->user()),
            'moduleProgress' => [],
            'purchaseSuccess' => true,
        ]);
    }

    public function scormCommit(Request $request, string $courseSlug, string $moduleId)
    {
        $course = Course::published()
            ->where('slug', $courseSlug)
            ->firstOrFail();

        $module = CourseModule::where('course_id', $course->id)
            ->where('id', $moduleId)
            ->firstOrFail();

        $user = auth()->user();

        if (!$course->isAccessibleBy($user)) {
            abort(403, 'You do not have access to this course.');
        }

        $enrolment = Enrolment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $progress = ModuleProgress::where('enrolment_id', $enrolment->id)
            ->where('module_id', $module->id)
            ->firstOrFail();

        $progress->updateScormData($request->all());

        return response()->json(['success' => true]);
    }

    public function completeModule(Request $request, string $courseSlug, string $moduleId)
    {
        $course = Course::published()
            ->where('slug', $courseSlug)
            ->firstOrFail();

        $module = CourseModule::where('course_id', $course->id)
            ->where('id', $moduleId)
            ->firstOrFail();

        $user = auth()->user();

        $enrolment = Enrolment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $progress = ModuleProgress::where('enrolment_id', $enrolment->id)
            ->where('module_id', $module->id)
            ->firstOrFail();

        // Handle SCORM data if provided
        if ($request->has('scorm_data')) {
            $progress->updateScormData($request->scorm_data);
        } else {
            $progress->markAsCompleted($request->input('score'));
        }

        $nextModule = $module->getNextModule();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'progress' => $enrolment->fresh()->progress_percentage,
                'next_module' => $nextModule?->id,
            ]);
        }

        if ($nextModule) {
            return redirect()->route('training.module', [$course->slug, $nextModule->id])
                ->with('success', 'Module completed!');
        }

        return redirect()->route('training.show', $course->slug)
            ->with('success', 'Congratulations! You have completed the course.');
    }
}
