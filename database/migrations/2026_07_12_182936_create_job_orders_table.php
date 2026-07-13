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
        Schema::create('job_orders', function (Blueprint $table) {
    $table->id('order_id');
    $table->unsignedBigInteger('customer_id');
    $table->unsignedBigInteger('shop_id');
    $table->unsignedBigInteger('service_id');
    $table->unsignedBigInteger('staff_id')->nullable();
    $table->unsignedBigInteger('measurement_id');
    $table->string('status')->default('Pending');
    $table->decimal('total_cost', 8, 2);
    $table->date('due_date');
    $table->timestamps();

    $table->foreign('customer_id')->references('customer_id')->on('customer_profiles')->onDelete('cascade');
    $table->foreign('shop_id')->references('shop_id')->on('shops')->onDelete('cascade');
    $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
    $table->foreign('staff_id')->references('staff_id')->on('tailoring_staff_profiles')->onDelete('set null');
    $table->foreign('measurement_id')->references('measurement_id')->on('measurements')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
