<x-layouts.app :title="$course->title">
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 mb-4">
                @if($course->is_free)
                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">FREE</span>
                @endif
                @if($course->cpd_accredited)
                    <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">{{ $course->cpd_points }} CPD POINTS</span>
                @endif
            </div>
            <h1 class="text-3xl font-bold mb-4">{{ $course->title }}</h1>
            <p class="text-gray-300 max-w-3xl">{{ $course->description }}</p>
            
            <div class="flex items-center gap-6 mt-6 text-sm">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    {{ $course->modules->count() }} modules
                </span>
                @if($course->formatted_duration)
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $course->formatted_duration }}
                    </span>
                @endif
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    {{ number_format($course->enrolments_count) }} enrolled
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Learning Outcomes -->
                @if($course->learning_outcomes && count($course->learning_outcomes) > 0)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">What You'll Learn</h2>
                        <ul class="grid md:grid-cols-2 gap-3">
                            @foreach($course->learning_outcomes as $outcome)
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-gray-700">{{ $outcome }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Course Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900">Course Content</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($course->modules as $index => $module)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-4">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 
                                        {{ isset($moduleProgress[$module->id]) && $moduleProgress[$module->id] === 'completed' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                        @if(isset($moduleProgress[$module->id]) && $moduleProgress[$module->id] === 'completed')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="font-medium text-gray-900">{{ $module->title }}</h3>
                                            <span class="text-xs text-gray-400 capitalize bg-gray-100 px-2 py-0.5 rounded">{{ $module->content_type }}</span>
                                        </div>
                                        @if($module->description)
                                            <p class="text-sm text-gray-500 line-clamp-2">{{ $module->description }}</p>
                                        @endif
                                        @if($module->duration_minutes)
                                            <p class="text-xs text-gray-400 mt-1">{{ $module->formatted_duration }}</p>
                                        @endif
                                    </div>
                                    @if($hasAccess)
                                        <a 
                                            href="{{ route('training.module', [$course->slug, $module->id]) }}" 
                                            class="text-green-600 hover:text-green-700 text-sm font-medium"
                                        >
                                            {{ isset($moduleProgress[$module->id]) && $moduleProgress[$module->id] === 'completed' ? 'Review' : 'Start' }}
                                        </a>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 sticky top-24">
                    @if($enrolment)
                        <!-- Already enrolled -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="text-gray-500">Your Progress</span>
                                <span class="font-semibold text-green-600">{{ $enrolment->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-600 h-3 rounded-full transition-all" style="width: {{ $enrolment->progress_percentage }}%"></div>
                            </div>
                        </div>

                        @php
                            $nextModule = $course->modules->first(fn($m) => !isset($moduleProgress[$m->id]) || $moduleProgress[$m->id] !== 'completed');
                        @endphp

                        @if($nextModule)
                            <a 
                                href="{{ route('training.module', [$course->slug, $nextModule->id]) }}"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2"
                            >
                                Continue Learning
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        @else
                            <div class="text-center">
                                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-900">Course Completed!</p>
                                <p class="text-sm text-gray-500 mt-1">Completed on {{ $enrolment->completed_at?->format('d M Y') }}</p>
                            </div>
                        @endif
                    @elseif($hasAccess)
                        <!-- Has access but not enrolled -->
                        <form method="POST" action="{{ route('training.enrol', $course->slug) }}">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                                Start Course
                            </button>
                        </form>
                    @elseif($course->is_free)
                        <!-- Free course, need to enrol -->
                        <form method="POST" action="{{ route('training.enrol', $course->slug) }}">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                                Enrol for Free
                            </button>
                        </form>
                    @else
                        <!-- Paid course, need to purchase -->
                        <div class="text-center mb-6">
                            <div class="text-3xl font-bold text-gray-900">{{ $course->formatted_price }}</div>
                            <p class="text-sm text-gray-500">One-time payment</p>
                        </div>
                        <a 
                            href="{{ route('training.purchase', $course->slug) }}"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center"
                        >
                            Purchase Course
                        </a>
                    @endif

                    @if($course->cpd_accredited)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                <span>CPD Accredited · {{ $course->cpd_points }} points</span>
                            </div>
                            @if($course->accreditation_body)
                                <p class="text-xs text-gray-400 mt-1 ml-7">{{ $course->accreditation_body }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
