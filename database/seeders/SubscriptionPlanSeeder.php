<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'plan_name' => 'Basic',
                'billing_cycle' => 'Monthly',
                'price' => 249.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plan_name' => 'Pro',
                'billing_cycle' => 'Monthly',
                'price' => 699.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plan_name' => 'Premium',
                'billing_cycle' => 'Monthly',
                'price' => 1299.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plan_name' => 'Basic',
                'billing_cycle' => 'Yearly',
                'price' => 2490.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plan_name' => 'Pro',
                'billing_cycle' => 'Yearly',
                'price' => 6990.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plan_name' => 'Premium',
                'billing_cycle' => 'Yearly',
                'price' => 12990.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // I-insert ang data sa subscription_plans table
        DB::table('subscription_plans')->insert($plans);
    }
}