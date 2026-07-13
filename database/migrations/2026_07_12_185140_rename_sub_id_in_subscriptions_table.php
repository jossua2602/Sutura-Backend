<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Papalitan natin ang 'sub_id' ng 'subscription_id'
            $table->renameColumn('sub_id', 'subscription_id');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Para ibalik sa dati kung sakaling mag-rollback
            $table->renameColumn('subscription_id', 'sub_id');
        });
    }
};