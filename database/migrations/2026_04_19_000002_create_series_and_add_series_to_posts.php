<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->string('status', 30)->default('active')->index();
            $table->timestamps();
        });

        Schema::table('media_posts', function (Blueprint $table) {
            $table->foreignId('series_id')->nullable()->constrained('series')->nullOnDelete()->after('type');
            $table->unsignedSmallInteger('series_order')->nullable()->after('series_id');
        });
    }

    public function down(): void
    {
        Schema::table('media_posts', function (Blueprint $table) {
            $table->dropForeign(['series_id']);
            $table->dropColumn(['series_id', 'series_order']);
        });

        Schema::dropIfExists('series');
    }
};
