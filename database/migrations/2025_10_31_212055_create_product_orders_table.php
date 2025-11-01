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
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('optical_product_id')->constrained('optical_products')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patient_profiles')->onDelete('cascade');
            $table->foreignId('prescription_id')->nullable()->constrained('prescriptions')->onDelete('set null');
            $table->boolean('is_accepted')->default(false);
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');
            $table->integer('total_price');
            $table->date('delivery_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_orders');
    }
};
