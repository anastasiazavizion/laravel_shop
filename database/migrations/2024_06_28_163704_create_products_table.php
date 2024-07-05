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
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->string('SKU')->unique();
            $table->text('description')->nullable();
            $table->float('price')->unsigned()->startingValue(1);
            $table->integer('discount')->nullable();
            $table->unsignedTinyInteger('quantity')->default(0);
            $table->tinyText('thumbnail');

            $table->fullText(['title']);
            $table->fullText(['slug']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
   /*     Schema::table('products', function (Blueprint $table){
            $table->dropFullText(['title']);
            $table->dropFullText(['products']);
        });*/

        Schema::dropIfExists('products');
    }
};
