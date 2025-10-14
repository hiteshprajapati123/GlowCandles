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
        Schema::create('privacy_policy_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title');
            $table->text('banner_subtitle')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('introduction_title');
            $table->text('introduction_content');
            $table->string('information_collection_title');
            $table->text('information_collection_content');
            $table->string('how_we_use_title');
            $table->text('how_we_use_content');
            $table->string('information_sharing_title');
            $table->text('information_sharing_content');
            $table->string('data_security_title');
            $table->text('data_security_content');
            $table->string('your_rights_title');
            $table->text('your_rights_content');
            $table->string('cookies_title')->nullable();
            $table->text('cookies_content')->nullable();
            $table->string('third_party_links_title')->nullable();
            $table->text('third_party_links_content')->nullable();
            $table->string('children_privacy_title')->nullable();
            $table->text('children_privacy_content')->nullable();
            $table->string('policy_changes_title')->nullable();
            $table->text('policy_changes_content')->nullable();
            $table->string('contact_us_title')->nullable();
            $table->text('contact_us_content')->nullable();
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
        Schema::dropIfExists('privacy_policy_pages');
    }
};
