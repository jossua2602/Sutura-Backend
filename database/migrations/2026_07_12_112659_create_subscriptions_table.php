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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id('sub_id'); // Primary key na tugma sa Model mo
            $table->string('shop_name');
            $table->string('plan');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
