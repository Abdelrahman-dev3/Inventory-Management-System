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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable(); 
            $table->unsignedBigInteger('category_id')->nullable(); 
            $table->unsignedBigInteger('product_id')->nullable(); 
            $table->unsignedBigInteger('in_qty')->nullable(); 
            $table->unsignedBigInteger('out_qty')->nullable(); 
            $table->unsignedBigInteger('stock')->nullable(); 
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
