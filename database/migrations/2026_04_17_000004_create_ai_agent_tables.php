<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->default('Percakapan Baru');
            $table->string('type')->default('general')->index();
            $table->string('goal')->nullable();
            $table->string('audience')->nullable();
            $table->string('tone')->nullable();
            $table->string('status')->default('active')->index();
            $table->json('context')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_conversation_id')->constrained()->cascadeOnDelete();
            $table->string('role', 30)->index();
            $table->string('provider', 30)->nullable()->index();
            $table->longText('content');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('media_post_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('berita')->index();
            $table->string('title');
            $table->string('category')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->json('sources')->nullable();
            $table->json('metadata')->nullable();
            $table->string('status')->default('generated')->index();
            $table->timestamps();
        });

        Schema::create('ai_provider_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_conversation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider', 30)->index();
            $table->string('model')->nullable();
            $table->string('action')->nullable()->index();
            $table->longText('input')->nullable();
            $table->longText('output')->nullable();
            $table->string('status')->default('completed')->index();
            $table->unsignedInteger('tokens_input')->nullable();
            $table->unsignedInteger('tokens_output')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_provider_runs');
        Schema::dropIfExists('ai_drafts');
        Schema::dropIfExists('ai_messages');
        Schema::dropIfExists('ai_conversations');
    }
};
