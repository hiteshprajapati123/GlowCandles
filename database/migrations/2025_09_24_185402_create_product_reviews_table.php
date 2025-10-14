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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Review content
            $table->integer('rating'); // 1-5
            $table->string('title');
            $table->text('comment');
            $table->json('images')->nullable();
            
            // Moderation
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Additional
            $table->json('pros')->nullable();
            $table->json('cons')->nullable();
            
            // Helpfulness
            $table->integer('helpful_yes')->default(0);
            $table->integer('helpful_no')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['product_id', 'is_approved']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
