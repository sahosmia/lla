<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Larabuild\Optionbuilder\Facades\Settings;

class CurrencyConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $section_key        = '_general';
        $field_key          = 'multi_currency_list';
        $existingCurrency   = setting($section_key . '.' . $field_key);

        if (empty($existingCurrency) || !is_array($existingCurrency) || isset($existingCurrency[0]['code'])) {
            return;
        }

        $updatedCurrency = [];
        foreach ($existingCurrency as $item) {
            if (!empty($item) && $item !== setting('_general.base_currency')) {
                $updatedCurrency[] = [
                    'code'            => strtoupper($item),
                    'conversion_rate' => (float) 1.00,
                ];
            }
        }
        Settings::set($section_key, $field_key, $updatedCurrency);
    }
}
