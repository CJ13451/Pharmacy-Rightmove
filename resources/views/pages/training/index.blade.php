<x-layouts.app title="Training & CPD">
<div class="training-hero">
    <div class="container">
        <div class="training-hero-content">
            <h1>Pharmacy Ownership Training</h1>
            <p>CPD-accredited courses designed specifically for pharmacists buying, running, or growing their pharmacy business.</p>
            <a href="#courses" class="btn btn-green btn-lg">Browse All Courses</a>
        </div>
        <div class="training-stats">
            <div class="training-stat-item">
                <div class="training-stat-number">{{ $courses->count() }}</div>
                <div class="training-stat-text">Courses</div>
            </div>
            <div class="training-stat-item">
                <div class="training-stat-number">CPD</div>
                <div class="training-stat-text">Accredited</div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="courses">
    <div class="section" style="padding-top:40px">
        <div class="section-header">
            <h2 class="section-title">All Courses</h2>
        </div>
    </div>
    <div class="courses-grid">
        @forelse($courses as $course)
            <a href="{{ route('training.show', $course->slug) }}" class="course-card">
                <div class="course-image" style="background:linear-gradient(135deg, #00875a 0%, #006644 100%);">
                    @if($course->cpd_accredited)<div class="course-badges"><span class="badge badge-black">CPD</span></div>@endif
                    <span class="course-image-icon">&#x1F393;</span>
                </div>
                <div class="course-content">
                    <div class="course-category">{{ $course->category ?? 'Course' }}</div>
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <p class="course-desc">{{ Str::limit($course->description, 100) }}</p>
                    <div class="course-meta">
                        <span class="course-info">{{ $course->modules_count ?? 0 }} modules</span>
                        <span class="course-price {{ $course->is_free ? 'course-price-free' : '' }}">{{ $course->is_free ? 'Free' : '&pound;'.number_format($course->price / 100, 2) }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="empty-state" style="grid-column:1/-1;">No courses available yet. Check back soon!</div>
        @endforelse
    </div>
</div>
</x-layouts.app>
