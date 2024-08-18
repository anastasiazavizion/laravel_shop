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
        \App\Models\OrderStatus::create(['name'=>'In process']);
        \App\Models\OrderStatus::create(['name'=>'Paid']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
