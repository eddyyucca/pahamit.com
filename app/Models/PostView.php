<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostView extends Model
{
    protected $fillable = [
        'media_post_id',
        'viewed_on',
        'ip_hash',
        'user_agent',
        'referer',
        'path',
    ];

    protected function casts(): array
    {
        return [
            'viewed_on' => 'date',
        ];
    }

    public function mediaPost(): BelongsTo
    {
        return $this->belongsTo(MediaPost::class);
    }
}
