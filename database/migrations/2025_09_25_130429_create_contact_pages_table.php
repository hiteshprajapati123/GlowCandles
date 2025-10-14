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
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title');
            $table->text('banner_subtitle')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('contact_form_title');
            $table->text('contact_form_subtitle')->nullable();
            $table->string('contact_info_title');
            $table->text('contact_info_subtitle')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('business_hours_title')->nullable();
            $table->text('business_hours_content')->nullable();
            $table->string('social_media_title')->nullable();
            $table->text('social_media_subtitle')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->text('map_embed_code')->nullable();
            $table->string('faq_section_title')->nullable();
            $table->text('faq_section_subtitle')->nullable();
            $table->string('cta_section_title')->nullable();
            $table->text('cta_section_content')->nullable();
            $table->string('cta_button_text')->default('Shop Now');
            $table->string('cta_button_link')->default('/shop');
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
        Schema::dropIfExists('contact_pages');
    }
};
