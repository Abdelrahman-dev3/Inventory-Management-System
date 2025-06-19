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
        Schema::create('purchase_items', function (Blueprint $table) {
    $table->id(); 
    $table->unsignedBigInteger('purchase_id'); 
    $table->unsignedBigInteger('category_id'); 
    $table->unsignedBigInteger('product_id');  
    $table->integer('quantity'); 
    $table->decimal('unit_price', 10, 2); 
    $table->decimal('total_price', 12, 2); 
    $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
