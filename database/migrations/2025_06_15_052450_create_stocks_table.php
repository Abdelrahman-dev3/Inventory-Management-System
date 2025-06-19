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
            $table->unsignedBigInteger('supplier_id'); 
            $table->unsignedBigInteger('category_id'); 
            $table->unsignedBigInteger('product_id'); 
            $table->unsignedBigInteger('in_qty'); 
            $table->unsignedBigInteger('out_qty'); 
            $table->unsignedBigInteger('stock'); 
            $table->timestamps();
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
