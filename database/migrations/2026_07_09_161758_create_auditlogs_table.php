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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->unsignedBigInteger('user_id');
            $table->string('action'); // Binago natin mula action_type
            $table->string('table_name'); // Idagdag ito dahil ginamit natin sa logAction
            $table->unsignedBigInteger('record_id'); // Idagdag ito
            $table->text('details'); // Binago natin mula description
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs'); // Itinama ang pangalan
    }
};
