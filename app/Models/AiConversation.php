<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiConversation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'goal',
        'audience',
        'tone',
        'status',
        'context',
    ];

    protected function casts(): array
    {
        return [
            'context' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(AiMessage::class);
    }

    public function drafts(): HasMany
    {
        return $this->hasMany(AiDraft::class);
    }

    public function providerRuns(): HasMany
    {
        return $this->hasMany(AiProviderRun::class);
    }
}
