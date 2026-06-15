<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CountryState;
use Illuminate\Support\Facades\Schema;


class CountryStatesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Schema::disableForeignKeyConstraints();
        CountryState::truncate();
        Schema::enableForeignKeyConstraints();

        $states = array(
          
            '19' => array( // Bangladeshi states (districts).
                'BD-05' => 'Bagerhat',
                'BD-01' => 'Bandarban',
                'BD-02' => 'Barguna',
                'BD-06' => 'Barishal',
                'BD-07' => 'Bhola',
                'BD-03' => 'Bogura',
                'BD-04' => 'Brahmanbaria',
                'BD-09' => 'Chandpur',
                'BD-10' => 'Chattogram',
                'BD-12' => 'Chuadanga',
                'BD-11' => "Cox's Bazar",
                'BD-08' => 'Cumilla',
                'BD-13' => 'Dhaka',
                'BD-14' => 'Dinajpur',
                'BD-15' => 'Faridpur ',
                'BD-16' => 'Feni',
                'BD-19' => 'Gaibandha',
                'BD-18' => 'Gazipur',
                'BD-17' => 'Gopalganj',
                'BD-20' => 'Habiganj',
                'BD-21' => 'Jamalpur',
                'BD-22' => 'Jashore',
                'BD-25' => 'Jhalokati',
                'BD-23' => 'Jhenaidah',
                'BD-24' => 'Joypurhat',
                'BD-29' => 'Khagrachhari',
                'BD-27' => 'Khulna',
                'BD-26' => 'Kishoreganj',
                'BD-28' => 'Kurigram',
                'BD-30' => 'Kushtia',
                'BD-31' => 'Lakshmipur',
                'BD-32' => 'Lalmonirhat',
                'BD-36' => 'Madaripur',
                'BD-37' => 'Magura',
                'BD-33' => 'Manikganj ',
                'BD-39' => 'Meherpur',
                'BD-38' => 'Moulvibazar',
                'BD-35' => 'Munshiganj',
                'BD-34' => 'Mymensingh',
                'BD-48' => 'Naogaon',
                'BD-43' => 'Narail',
                'BD-40' => 'Narayanganj',
                'BD-42' => 'Narsingdi',
                'BD-44' => 'Natore',
                'BD-45' => 'Nawabganj',
                'BD-41' => 'Netrakona',
                'BD-46' => 'Nilphamari',
                'BD-47' => 'Noakhali',
                'BD-49' => 'Pabna',
                'BD-52' => 'Panchagarh',
                'BD-51' => 'Patuakhali',
                'BD-50' => 'Pirojpur',
                'BD-53' => 'Rajbari',
                'BD-54' => 'Rajshahi',
                'BD-56' => 'Rangamati',
                'BD-55' => 'Rangpur',
                'BD-58' => 'Satkhira',
                'BD-62' => 'Shariatpur',
                'BD-57' => 'Sherpur',
                'BD-59' => 'Sirajganj',
                'BD-61' => 'Sunamganj',
                'BD-60' => 'Sylhet',
                'BD-63' => 'Tangail',
                'BD-64' => 'Thakurgaon',
            ),
        
        );
        foreach ($states as $country_id => $states) {
            $is_district    = $country_id == '197' ? 1 : 0;
            $state_list     = [];
            foreach ($states as $short_code => $state_name) {
                $state_list[] = [
                    'country_id'    => $country_id,
                    'name'          => $state_name,
                    'short_code'    => $short_code,
                    'is_district'   => $is_district
                ];
            }
            CountryState::insert($state_list);
        }
    }
}
