<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Language::truncate();
        $languages = [
            
           
          
            [
                'name' => "Bengali",
                'code' => "bn",
                'status' => '1'
            ],
            
            
            
            [
                'name' => "English",
                'code' => "en",
                'status' => '1'
            ],
            
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                [
                    'name' => $language['name']
                ],
                [
                    'status' => $language['status'],
                    'code' => $language['code']
                ]
            );
        }
    }
}
