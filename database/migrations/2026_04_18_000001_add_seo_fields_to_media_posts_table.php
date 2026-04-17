<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_posts', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('excerpt');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('focus_keyword')->nullable()->after('seo_description');
            $table->json('tags')->nullable()->after('focus_keyword');
            $table->string('canonical_url')->nullable()->after('tags');
        });
    }

    public function down(): void
    {
        Schema::table('media_posts', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title',
                'seo_description',
                'focus_keyword',
                'tags',
                'canonical_url',
            ]);
        });
    }
};
