<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(config('optionbuilder.db_prefix') . 'settings')) {
            return;
        }

        $table = config('optionbuilder.db_prefix') . 'settings';

        $paymentMethodsRow = DB::table($table)
            ->where('section', 'admin_settings')
            ->where('key', 'payment_method')
            ->first();

        $paymentMethods = [];
        if ($paymentMethodsRow) {
            $paymentMethods = @unserialize($paymentMethodsRow->value) ?: [];
            if (!is_array($paymentMethods)) {
                $paymentMethods = [];
            }
        }

        $paymentMethods['sslcommerz'] = array_merge([
            'currency' => 'BDT',
            'store_id' => env('SSLCZ_STORE_ID', ''),
            'store_password' => env('SSLCZ_STORE_PASSWORD', ''),
            'status' => 'on',
            'exchange_rate' => '',
            'enable_test_mode' => env('SSLCZ_TESTMODE', true),
        ], $paymentMethods['sslcommerz'] ?? []);

        if (isset($paymentMethods['stripe'])) {
            $paymentMethods['stripe']['status'] = 'off';
        }

        DB::table($table)->updateOrInsert(
            ['section' => 'admin_settings', 'key' => 'payment_method'],
            ['value' => serialize($paymentMethods)]
        );

        DB::table($table)->updateOrInsert(
            ['section' => 'admin_settings', 'key' => 'default_payment_method'],
            ['value' => 'sslcommerz']
        );

        $generalRow = DB::table($table)
            ->where('section', '_general')
            ->where('key', 'currency')
            ->first();

        if ($generalRow) {
            DB::table($table)
                ->where('section', '_general')
                ->where('key', 'currency')
                ->update(['value' => serialize('BDT')]);
        }

        Cache::forget('optionbuilder__settings');
    }

    public function down(): void
    {
        //
    }
};
