<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiProviderRun extends Model
{
    protected $fillable = [
        'ai_conversation_id',
        'provider',
        'model',
        'action',
        'input',
        'output',
        'status',
        'tokens_input',
        'tokens_output',
        'error',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AiConversation::class, 'ai_conversation_id');
    }
}
