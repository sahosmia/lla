<?php

namespace Database\Seeders;

use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class PhoneNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $tutors = User::with('profile')->whereHas('roles', function ($query) {
            $query->whereIn('name', ['tutor', 'student']);
        })
            ->get();

        if ($tutors->isNotEmpty()) {
            foreach ($tutors as $tutor) {
                $tutor->profile()->update([
                    'phone_number' => '07123456789',
                ]);
            }
        }
    }
}
