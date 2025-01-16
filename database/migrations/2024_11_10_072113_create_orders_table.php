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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('status');
            $table->decimal('total', 8, 2);
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('shipping_method');
            $table->string('shipping_status');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_county');
            $table->string('shipping_country');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
