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
        Schema::create('shipping_policy_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title');
            $table->text('banner_subtitle')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('shipping_info_title');
            $table->text('shipping_info_content');
            $table->string('delivery_times_title');
            $table->text('delivery_times_content');
            $table->string('order_tracking_title');
            $table->text('order_tracking_content');
            $table->string('international_shipping_title')->nullable();
            $table->text('international_shipping_content')->nullable();
            $table->string('damaged_lost_packages_title')->nullable();
            $table->text('damaged_lost_packages_content')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq_content')->nullable();
            $table->string('contact_section_title')->nullable();
            $table->text('contact_section_content')->nullable();
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
        Schema::dropIfExists('shipping_policy_pages');
    }
};
