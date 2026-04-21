<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Series extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'cover_image_url', 'status'];

    public function posts(): HasMany
    {
        return $this->hasMany(MediaPost::class)->orderBy('series_order');
    }

    public function publishedPosts(): HasMany
    {
        return $this->hasMany(MediaPost::class)->where('status', 'published')->orderBy('series_order');
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
