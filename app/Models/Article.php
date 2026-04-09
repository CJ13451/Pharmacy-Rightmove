<?php

namespace App\Models;

use App\Enums\ArticleCategory;
use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'slug',
        'status',
        'title',
        'excerpt',
        'content',
        'content_format',
        'featured_image',
        'type',
        'category',
        'tags',
        'is_premium',
        'is_featured',
        'author_id',
        'views_count',
        'reading_time_minutes',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ArticleStatus::class,
            'type' => ArticleType::class,
            'category' => ArticleCategory::class,
            'tags' => 'array',
            'is_premium' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    // ----- Boot -----

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title) . '-' . Str::random(6);
            }
            $article->reading_time_minutes = $article->calculateReadingTime();
        });

        static::updating(function ($article) {
            if ($article->isDirty('content')) {
                $article->reading_time_minutes = $article->calculateReadingTime();
            }
        });
    }

    // ----- Relationships -----

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // ----- Accessors -----

    public function getAuthorNameAttribute(): string
    {
        return $this->author?->full_name ?? 'Unknown';
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->published_at?->format('j M Y') ?? 'Unpublished';
    }

    public function getExcerptOrTruncatedAttribute(): string
    {
        if ($this->excerpt) {
            return $this->excerpt;
        }

        // Strip HTML and truncate content
        $text = strip_tags($this->content ?? '');
        return Str::limit($text, 200);
    }

    // ----- Methods -----

    public function calculateReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        $minutes = ceil($wordCount / 200); // Average reading speed
        return max(1, $minutes);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function publish(): void
    {
        $this->update([
            'status' => ArticleStatus::PUBLISHED,
            'published_at' => now(),
        ]);
    }

    public function unpublish(): void
    {
        $this->update([
            'status' => ArticleStatus::DRAFT,
            'published_at' => null,
        ]);
    }

    // ----- Scopes -----

    public function scopePublished($query)
    {
        return $query->where('status', ArticleStatus::PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    public function scopeOfType($query, ArticleType $type)
    {
        return $query->where('type', $type);
    }

    public function scopeInCategory($query, ArticleCategory $category)
    {
        return $query->where('category', $category);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}
