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
    Schema::table('payments', function (Blueprint $table) {
        $table->foreign('order_id')->references('order_id')->on('job_orders')->onDelete('set null');
        $table->foreign('subscription_id')->references('subscription_id')->on('subscriptions')->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
};
