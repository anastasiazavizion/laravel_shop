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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Order::class)->constrained('orders')->cascadeOnDelete();

            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained('products')->nullOnDelete();


            $table->string('name');
            $table->string('quantity');
            $table->string('single_price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
