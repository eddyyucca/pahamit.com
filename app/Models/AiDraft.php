<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiDraft extends Model
{
    protected $fillable = [
        'ai_conversation_id',
        'media_post_id',
        'type',
        'title',
        'category',
        'excerpt',
        'content',
        'sources',
        'metadata',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'sources' => 'array',
            'metadata' => 'array',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AiConversation::class, 'ai_conversation_id');
    }

    public function mediaPost(): BelongsTo
    {
        return $this->belongsTo(MediaPost::class);
    }
}
