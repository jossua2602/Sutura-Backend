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
       Schema::create('tailoring_staff_profiles', function (Blueprint $table) {
    $table->id('staff_id');
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('shop_id');
    $table->string('first_name');
    $table->string('last_name');
    $table->string('working_status')->default('Active');
    $table->timestamps();

    // Foreign Keys (Assuming your PKs in users and shops are user_id and shop_id)
    $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
    $table->foreign('shop_id')->references('shop_id')->on('shops')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tailoring_staff_profiles');
    }
};
