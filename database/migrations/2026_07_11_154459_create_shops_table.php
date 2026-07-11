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
        Schema::create('shops', function (Blueprint $table) {
            // Unique identifier for each shop[cite: 3]
            $table->id('shop_id'); 
            
            // References USER table[cite: 3]. 
            // Gagamitin natin ang Developer Bypass muna dito para iwas foreign key errors.
            $table->unsignedBigInteger('owner_id'); 
            
            // Registered business name[cite: 3]
            $table->string('shop_name');
            
            // Physical address[cite: 3]
            $table->text('address');
            
            // Geographic coordinates[cite: 3]
            $table->string('coordinates')->nullable(); 
            
            // Operational approval state[cite: 3]
            $table->enum('verification_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
