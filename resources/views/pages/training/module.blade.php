<x-layouts.app :title="$module->title">
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('training.show', $course->slug) }}" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <div>
                            <p class="text-sm text-gray-500">{{ $course->title }}</p>
                            <h1 class="font-semibold text-gray-900">{{ $module->title }}</h1>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">
                            Module {{ $moduleIndex + 1 }} of {{ $course->modules->count() }}
                        </span>
                        @if($nextModule)
                            <a href="{{ route('training.module', [$course->slug, $nextModule->id]) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                Next Module →
                            </a>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm">
                                Final Module
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-8 py-8">
            <!-- Content based on type -->
            @if($module->content_type === 'text')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <div class="prose prose-lg prose-green max-w-none">
                        {!! $module->content_body !!}
                    </div>
                </div>

            @elseif($module->content_type === 'video')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="aspect-video bg-black">
                        @if($module->video_provider === 'youtube')
                            @php
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $module->video_url, $matches);
                                $videoId = $matches[1] ?? '';
                            @endphp
                            <iframe 
                                src="https://www.youtube.com/embed/{{ $videoId }}?rel=0" 
                                class="w-full h-full"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                            ></iframe>
                        @elseif($module->video_provider === 'vimeo')
                            @php
                                preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $module->video_url, $matches);
                                $videoId = $matches[1] ?? '';
                            @endphp
                            <iframe 
                                src="https://player.vimeo.com/video/{{ $videoId }}" 
                                class="w-full h-full"
                                frameborder="0" 
                                allow="autoplay; fullscreen; picture-in-picture" 
                                allowfullscreen
                            ></iframe>
                        @else
                            <video 
                                src="{{ $module->video_url }}" 
                                class="w-full h-full"
                                controls
                            ></video>
                        @endif
                    </div>
                    @if($module->description)
                        <div class="p-6 border-t border-gray-100">
                            <p class="text-gray-600">{{ $module->description }}</p>
                        </div>
                    @endif
                </div>

            @elseif($module->content_type === 'scorm')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div id="scorm-container" class="relative" style="min-height: 600px;">
                        <iframe 
                            id="scorm-frame"
                            src="{{ $module->scorm_entry_url }}"
                            class="w-full border-0"
                            style="height: 600px;"
                            allowfullscreen
                        ></iframe>
                    </div>
                    <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <div id="scorm-status" class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                                <span>In Progress</span>
                            </div>
                        </div>
                        <div id="scorm-score" class="text-sm font-medium text-gray-700"></div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/scorm-again@latest/dist/scorm-again.min.js"></script>
                <script>
                    // Initialize SCORM API
                    const settings = {
                        autocommit: true,
                        autocommitSeconds: 30,
                        lmsCommitUrl: '{{ route('training.scorm-commit', [$course->slug, $module->id]) }}',
                        @if($progress && $progress->scorm_data)
                        cmi: @json($progress->scorm_data),
                        @endif
                    };

                    @if($module->scorm_version === '2004')
                        window.API_1484_11 = new Scorm2004API(settings);
                        window.API_1484_11.on('SetValue.cmi.*', function(CMIElement, value) {
                            updateUI();
                        });
                    @else
                        window.API = new Scorm12API(settings);
                        window.API.on('SetValue.cmi.*', function(CMIElement, value) {
                            updateUI();
                        });
                    @endif

                    function updateUI() {
                        const statusEl = document.getElementById('scorm-status');
                        const scoreEl = document.getElementById('scorm-score');
                        
                        @if($module->scorm_version === '2004')
                            const status = window.API_1484_11.cmi.completion_status;
                            const score = window.API_1484_11.cmi.score.scaled;
                        @else
                            const status = window.API.cmi.core.lesson_status;
                            const score = window.API.cmi.core.score.raw;
                        @endif

                        if (status === 'completed' || status === 'passed') {
                            statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-green-500"></span><span>Completed</span>';
                        } else if (status === 'failed') {
                            statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-500"></span><span>Failed</span>';
                        }

                        if (score !== undefined && score !== '') {
                            scoreEl.textContent = 'Score: ' + Math.round(score * 100) + '%';
                        }
                    }

                    // Auto-resize iframe based on content
                    window.addEventListener('message', function(e) {
                        if (e.data && e.data.height) {
                            document.getElementById('scorm-frame').style.height = e.data.height + 'px';
                        }
                    });
                </script>

            @elseif($module->content_type === 'download')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $module->download_name ?? 'Download Resource' }}</h2>
                    @if($module->description)
                        <p class="text-gray-600 mb-6 max-w-lg mx-auto">{{ $module->description }}</p>
                    @endif
                    <a 
                        href="{{ $module->download_url }}" 
                        download
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download File
                    </a>
                </div>

            @elseif($module->content_type === 'quiz')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Module Quiz</h2>
                        <p class="text-gray-600">Complete this quiz to finish the module. You need {{ $module->pass_percentage }}% to pass.</p>
                    </div>
                    
                    <!-- Quiz would be implemented with Livewire or similar -->
                    <div class="text-center text-gray-500 py-8">
                        <p>Quiz functionality requires additional implementation.</p>
                    </div>
                </div>
            @endif

            <!-- Mark as Complete -->
            @if(!$isCompleted && $module->content_type !== 'scorm')
                <div class="mt-6 flex justify-center">
                    <form method="POST" action="{{ route('training.complete-module', [$course->slug, $module->id]) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark as Complete
                        </button>
                    </form>
                </div>
            @elseif($isCompleted)
                <div class="mt-6 flex justify-center">
                    <div class="inline-flex items-center gap-2 text-green-600 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Module Completed
                    </div>
                </div>
            @endif

            <!-- Module Navigation -->
            <div class="mt-8 flex items-center justify-between">
                @if($prevModule)
                    <a href="{{ route('training.module', [$course->slug, $prevModule->id]) }}" class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Previous: {{ Str::limit($prevModule->title, 30) }}
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextModule)
                    <a href="{{ route('training.module', [$course->slug, $nextModule->id]) }}" class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition">
                        Next: {{ Str::limit($nextModule->title, 30) }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('training.show', $course->slug) }}" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium transition">
                        Back to Course
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
