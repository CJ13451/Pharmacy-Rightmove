<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseModule;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        if (Course::query()->exists()) {
            $this->command?->info('Courses already seeded, skipping.');
            return;
        }

        $courses = [
            [
                'title' => 'Pre-Ownership Programme',
                'description' => 'A comprehensive eight-module CPD-accredited programme covering everything prospective pharmacy owners need to know before they make an offer — from due diligence and valuation through to financing, TUPE and the first 90 days in ownership.',
                'learning_outcomes' => [
                    'Evaluate a target pharmacy against objective financial and operational benchmarks',
                    'Interpret management accounts and identify common red flags',
                    'Structure an offer with appropriate contingencies',
                    'Understand the main financing routes and lender expectations',
                    'Plan a 100-day onboarding playbook for a newly acquired pharmacy',
                ],
                'cpd_accredited' => true,
                'cpd_points' => 8,
                'is_free' => false,
                'price' => 249_00,
                'modules' => [
                    ['title' => 'Welcome and course overview', 'content_type' => 'text', 'duration' => 10],
                    ['title' => 'What do you want to own?', 'content_type' => 'text', 'duration' => 25],
                    ['title' => 'Reading pharmacy accounts', 'content_type' => 'video', 'duration' => 35],
                    ['title' => 'Valuation methods explained', 'content_type' => 'video', 'duration' => 30],
                    ['title' => 'Due diligence checklist in practice', 'content_type' => 'download', 'duration' => 20],
                    ['title' => 'Financing your acquisition', 'content_type' => 'text', 'duration' => 25],
                    ['title' => 'Deal structuring and completion', 'content_type' => 'text', 'duration' => 30],
                    ['title' => 'Your first 100 days', 'content_type' => 'text', 'duration' => 25],
                ],
            ],
            [
                'title' => 'Pharmacy Valuation Masterclass',
                'description' => 'A focused masterclass on valuation methodologies used by brokers, banks and buyers. Includes worked examples, sensitivity analysis and a downloadable valuation model.',
                'learning_outcomes' => [
                    'Understand the difference between goodwill, fixtures & fittings and stock',
                    'Apply different valuation multiples by pharmacy type',
                    'Build a simple valuation model and sensitivity analysis',
                    'Recognise what drives a premium or a discount',
                ],
                'cpd_accredited' => true,
                'cpd_points' => 4,
                'is_free' => false,
                'price' => 129_00,
                'modules' => [
                    ['title' => 'Valuation fundamentals', 'content_type' => 'video', 'duration' => 20],
                    ['title' => 'Multiples explained', 'content_type' => 'video', 'duration' => 25],
                    ['title' => 'Sensitivity analysis walkthrough', 'content_type' => 'video', 'duration' => 30],
                    ['title' => 'Downloadable valuation model', 'content_type' => 'download', 'duration' => 15],
                ],
            ],
            [
                'title' => 'Introduction to Pharmacy Ownership (Free)',
                'description' => 'A free taster course for anyone thinking about owning a community pharmacy. Gives you a feel for the platform, the topics we cover and the depth of the paid programmes.',
                'learning_outcomes' => [
                    'Get an overview of the UK pharmacy ownership landscape',
                    'Understand the main routes into ownership',
                    'Decide whether ownership is the right next step for you',
                ],
                'cpd_accredited' => false,
                'is_free' => true,
                'price' => null,
                'modules' => [
                    ['title' => 'Why own a pharmacy?', 'content_type' => 'text', 'duration' => 10],
                    ['title' => 'Routes into ownership', 'content_type' => 'text', 'duration' => 15],
                    ['title' => 'What the journey looks like', 'content_type' => 'video', 'duration' => 18],
                ],
            ],
            [
                'title' => 'New Owner Operations Essentials',
                'description' => 'The practical operations playbook for first-time owners — SOPs, rotas, stock control, governance and staff management in the first year.',
                'learning_outcomes' => [
                    'Design a sensible SOP framework for a single-site pharmacy',
                    'Set up efficient rotas and holiday cover',
                    'Manage stock, returns and short-dated lines',
                    'Run effective staff 1-to-1s and performance reviews',
                ],
                'cpd_accredited' => true,
                'cpd_points' => 6,
                'is_free' => false,
                'price' => 189_00,
                'modules' => [
                    ['title' => 'Your SOP framework', 'content_type' => 'text', 'duration' => 25],
                    ['title' => 'Building the rota', 'content_type' => 'video', 'duration' => 20],
                    ['title' => 'Stock control and shrinkage', 'content_type' => 'text', 'duration' => 30],
                    ['title' => 'Managing the team', 'content_type' => 'video', 'duration' => 25],
                    ['title' => 'Governance and CQC-style checks', 'content_type' => 'text', 'duration' => 25],
                ],
            ],
            [
                'title' => 'Growing Clinical Services Income',
                'description' => 'Practical guidance on launching and scaling clinical services — Pharmacy First, travel, independent prescribing — in a community pharmacy setting.',
                'learning_outcomes' => [
                    'Choose the right services mix for your patient base',
                    'Plan for physical space, equipment and staff training',
                    'Market services effectively to patients and local GPs',
                    'Measure service profitability by income stream',
                ],
                'cpd_accredited' => true,
                'cpd_points' => 5,
                'is_free' => false,
                'price' => 149_00,
                'modules' => [
                    ['title' => 'The services landscape in 2026', 'content_type' => 'video', 'duration' => 20],
                    ['title' => 'Pharmacy First in practice', 'content_type' => 'text', 'duration' => 30],
                    ['title' => 'Independent prescribing case study', 'content_type' => 'video', 'duration' => 35],
                    ['title' => 'Marketing and demand generation', 'content_type' => 'text', 'duration' => 20],
                ],
            ],
        ];

        foreach ($courses as $courseData) {
            $modules = $courseData['modules'];
            unset($courseData['modules']);

            $course = Course::create(array_merge($courseData, [
                'status' => 'published',
                'accreditation_body' => ($courseData['cpd_accredited'] ?? false) ? 'CPPE' : null,
                'is_premium' => false,
                'enrolments_count' => random_int(25, 400),
                'completions_count' => random_int(10, 180),
                'average_rating' => round(mt_rand(40, 50) / 10, 1),
            ]));

            foreach ($modules as $index => $module) {
                CourseModule::create([
                    'course_id' => $course->id,
                    'position' => $index + 1,
                    'title' => $module['title'],
                    'content_type' => $module['content_type'],
                    'duration_minutes' => $module['duration'],
                    'content_body' => $module['content_type'] === 'text'
                        ? '<p>This is a demonstration module. Replace with real editorial content from the admin panel.</p>'
                        : null,
                    'video_url' => $module['content_type'] === 'video'
                        ? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
                        : null,
                    'video_provider' => $module['content_type'] === 'video' ? 'youtube' : null,
                    'download_name' => $module['content_type'] === 'download'
                        ? 'Sample download.pdf'
                        : null,
                    'requires_completion' => true,
                ]);
            }
        }

        $this->command?->info('Seeded '.count($courses).' courses.');
    }
}
