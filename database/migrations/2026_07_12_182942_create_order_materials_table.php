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
        Schema::create('order_materials', function (Blueprint $table) {
    $table->id('order_material_id');
    $table->unsignedBigInteger('order_id');
    $table->string('material_description');
    $table->string('quantity_used');
    $table->timestamps();

    $table->foreign('order_id')->references('order_id')->on('job_orders')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_materials');
    }
};
