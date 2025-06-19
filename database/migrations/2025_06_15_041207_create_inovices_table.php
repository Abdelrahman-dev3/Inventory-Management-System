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
        Schema::create('inovices', function (Blueprint $table) {
            $table->id(); // inovice No
            $table->unsignedBigInteger('customer_id'); 
            $table->text('discreption'); 
            $table->decimal('total_before_discount'); 
            $table->decimal('discount'); 
            $table->decimal('total_after_discount'); 
            $table->string('paid_status')->default(0);
            $table->timestamps(); // date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inovices');
    }
};
