<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title');
            $table->text('banner_subtitle')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('section1_title');
            $table->text('section1_content');
            $table->string('section1_image')->nullable();
            $table->string('section2_title')->nullable();
            $table->text('section2_content')->nullable();
            $table->string('section2_image')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission_content')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_content')->nullable();
            $table->string('team_section_title')->nullable();
            $table->text('team_section_subtitle')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
