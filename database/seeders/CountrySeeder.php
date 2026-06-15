<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\Schema;


class CountrySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Schema::disableForeignKeyConstraints();
        
        Country::truncate();
        Schema::enableForeignKeyConstraints();
        $countries = [

           
            ['name' => 'Bangladesh', 'short_code' => 'BD', 'status' => '1'],
           
        ];
        Country::insert($countries);
    }
}
