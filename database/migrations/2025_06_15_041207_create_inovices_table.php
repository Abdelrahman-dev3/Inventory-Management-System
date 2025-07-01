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
            $table->text('discreption')->nullable(); 
            $table->decimal('total_before_discount'); 
            $table->decimal('discount', 8, 2)->default(0)->nullable();
            $table->decimal('total_after_discount'); 
            $table->string('paid_status')->default(0);
            $table->timestamps(); // date

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
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
