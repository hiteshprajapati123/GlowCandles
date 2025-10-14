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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->string('cart_id'); // Can be session ID for guests or user ID for logged-in users
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            
            // Item details
            $table->integer('quantity')->default(1);
            $table->decimal('price', 12, 2);
            $table->json('options')->nullable(); // For variant options
            
            // Timestamps
            $table->timestamp('added_at');
            $table->timestamps();
            
            // Indexes
            $table->index(['cart_id', 'product_id']);
            $table->index(['user_id', 'added_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
