<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_posts', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('image_url');
            $table->unsignedBigInteger('views_count')->default(0)->after('image_path');
        });

        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date')->index();
            $table->string('path')->nullable();
            $table->string('ip_hash', 64)->nullable()->index();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visits');

        Schema::table('media_posts', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'views_count']);
        });
    }
};
