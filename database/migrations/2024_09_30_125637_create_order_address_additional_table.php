<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_address_coordinates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained('orders')->cascadeOnDelete();
            $table->decimal('lat', 8, 6)->nullable(); // Up to 8 digits, 6 after the decimal
            $table->decimal('lng', 9, 6)->nullable(); // Up to 9 digits, 6 after the decimal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_address_additional');
    }
};
