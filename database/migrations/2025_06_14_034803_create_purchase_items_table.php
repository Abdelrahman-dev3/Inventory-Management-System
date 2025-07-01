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
    $table->unsignedBigInteger('category_id')->nullable();
    $table->unsignedBigInteger('product_id')->nullable(); 
    $table->integer('quantity'); 
    $table->decimal('unit_price', 10, 2); 
    $table->decimal('total_price', 12, 2); 
    $table->timestamps();

    $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade')->onUpdate('cascade');
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
    $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('cascade');
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
