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
        Schema::create('products', function (Blueprint $table) {
            // Basic Information
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Pricing
            $table->decimal('price', 12, 2);
            $table->decimal('compare_at_price', 12, 2)->nullable();
            $table->decimal('cost_per_item', 12, 2)->nullable();
            
            // Inventory
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            $table->integer('quantity')->default(0);
            $table->boolean('track_quantity')->default(true);
            $table->boolean('sell_when_out_of_stock')->default(false);
            
            // Product Type & Status
            $table->enum('type', ['simple', 'variable', 'digital', 'service'])->default('simple');
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            
            // Media
            $table->string('main_image')->nullable();
            $table->json('images')->nullable();
            
            // Organization
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('brand')->nullable();
            $table->json('tags')->nullable();
            
            // Shipping
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('weight_unit', 10)->default('g');
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->string('dimension_unit', 10)->default('cm');
            
            // Variants (for simple products)
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('material')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            
            // Additional Information
            $table->json('features')->nullable();
            $table->json('specifications')->nullable();
            $table->text('warranty')->nullable();
            
            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_new')->default(true);
            $table->boolean('is_active')->default(true);
            
            // Counters
            $table->integer('view_count')->default(0);
            $table->integer('sold_count')->default(0);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['status', 'is_active']);
            $table->index(['category_id', 'is_active']);
            $table->index(['price', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
