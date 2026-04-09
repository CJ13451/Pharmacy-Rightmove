<x-layouts.app title="Training & CPD">
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-2">Training & CPD</h1>
            <p class="text-gray-300">Accredited courses for pharmacy professionals. Build your skills with expert-led training.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <form method="GET" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-wrap gap-4">
                <select name="pricing" class="rounded-lg border-gray-300 text-sm">
                    <option value="">All Courses</option>
                    <option value="free" {{ request('pricing') === 'free' ? 'selected' : '' }}>Free Courses</option>
                    <option value="paid" {{ request('pricing') === 'paid' ? 'selected' : '' }}>Paid Courses</option>
                </select>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="cpd_only" value="1" {{ request()->boolean('cpd_only') ? 'checked' : '' }} class="rounded border-gray-300 text-green-600">
                    <span class="text-sm text-gray-700">CPD Accredited Only</span>
                </label>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium">
                    Filter
                </button>
            </div>
        </form>

        <!-- Course Grid -->
        @if($courses->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <a href="{{ route('training.show', $course->slug) }}" class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition group flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-600 relative">
                            @if($course->thumbnail)
                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 flex gap-2">
                                @if($course->is_free)
                                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">FREE</span>
                                @endif
                                @if($course->cpd_accredited)
                                    <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">CPD</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 group-hover:text-green-600 transition line-clamp-2 mb-2">{{ $course->title }}</h3>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">{{ Str::limit($course->description, 100) }}</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span>{{ $course->modules_count }} modules</span>
                                    @if($course->formatted_duration)
                                        <span>{{ $course->formatted_duration }}</span>
                                    @endif
                                </div>
                                <div class="font-bold {{ $course->is_free ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $course->is_free ? 'Free' : $course->formatted_price }}
                                </div>
                            </div>

                            @if(isset($userEnrolments[$course->id]))
                                <div class="mt-3">
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="text-gray-500">Progress</span>
                                        <span class="font-medium text-green-600">{{ $userEnrolments[$course->id] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $userEnrolments[$course->id] }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @else
            <div class="bg-gray-50 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No courses found</h3>
                <p class="text-gray-500 mb-4">Check back soon for new training content.</p>
                <a href="{{ route('training.index') }}" class="text-green-600 hover:text-green-700 font-medium">Clear filters</a>
            </div>
        @endif
    </div>
</x-layouts.app>
