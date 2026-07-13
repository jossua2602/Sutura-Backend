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
        Schema::create('feedbacks', function (Blueprint $table) {
    $table->id('feedback_id');
    $table->unsignedBigInteger('order_id');
    $table->unsignedBigInteger('customer_id');
    $table->integer('rating'); // 1-5
    $table->text('comments')->nullable();
    $table->timestamps(); // Papalit sa created_at

    $table->foreign('order_id')->references('order_id')->on('job_orders')->onDelete('cascade');
    $table->foreign('customer_id')->references('customer_id')->on('customer_profiles')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
