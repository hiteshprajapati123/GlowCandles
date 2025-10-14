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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->string('logo')->nullable();
            $table->json('config')->nullable(); // For storing method-specific config like UPI ID, QR code, etc.
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default payment methods
        DB::table('payment_methods')->insert([
            [
                'name' => 'UPI Payment',
                'code' => 'upi',
                'description' => 'Pay instantly using UPI',
                'config' => json_encode([
                    'qr_code' => 'images/upi-qr-code.png',
                    'upi_id' => 'yourstore@upi',
                    'instructions' => 'Scan the QR code or send money to the UPI ID shown above',
                ]),
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cash on Delivery',
                'code' => 'cod',
                'description' => 'Pay when you receive your order',
                'config' => json_encode([
                    'instructions' => 'Pay with cash when your order is delivered',
                ]),
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
