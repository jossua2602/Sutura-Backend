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
        Schema::create('measurements', function (Blueprint $table) {
    $table->id('measurement_id');
    $table->unsignedBigInteger('customer_id');
    $table->unsignedBigInteger('shop_id');
    $table->json('measurement_data');
    $table->timestamps(); // Ito na rin ang magsisilbing updated_at

    $table->foreign('customer_id')->references('customer_id')->on('customer_profiles')->onDelete('cascade');
    $table->foreign('shop_id')->references('shop_id')->on('shops')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
