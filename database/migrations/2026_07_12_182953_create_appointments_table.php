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
       Schema::create('appointments', function (Blueprint $table) {
    $table->id('appointment_id');
    $table->unsignedBigInteger('customer_id');
    $table->unsignedBigInteger('shop_id');
    $table->timestamp('schedule_date');
    $table->string('purpose')->nullable();
    $table->string('status')->default('Scheduled');
    $table->timestamps();

    $table->foreign('customer_id')->references('customer_id')->on('customer_profiles')->onDelete('cascade');
    $table->foreign('shop_id')->references('shop_id')->on('shops')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
