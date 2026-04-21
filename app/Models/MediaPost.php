<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaPost extends Model
{
    /** @use HasFactory<\Database\Factories\MediaPostFactory> */
    use HasFactory;

    public const TYPE_BERITA = 'berita';
    public const TYPE_TUTORIAL = 'tutorial';
    public const TYPE_JUALAN = 'jualan';

    protected $fillable = [
        'user_id',
        'type',
        'series_id',
        'series_order',
        'title',
        'slug',
        'category',
        'excerpt',
        'seo_title',
        'seo_description',
        'focus_keyword',
        'tags',
        'canonical_url',
        'content',
        'price',
        'status',
        'image_url',
        'image_path',
        'image_prompt',
        'image_generation_model',
        'views_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'tags' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return url('storage/' . ltrim($this->image_path, '/'));
        }

        return $this->image_url;
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
