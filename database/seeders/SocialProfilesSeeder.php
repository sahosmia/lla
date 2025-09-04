<?php

namespace Database\Seeders;

use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class SocialProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $tutors = User::with('socialProfiles')->whereHas('roles', function ($query) {
            $query->where('name', 'tutor');
        })
            ->get();

        if ($tutors->isNotEmpty()) {
            foreach ($tutors as $tutor) {
                $tutor->socialProfiles()->delete();
                SocialProfile::insert([
                    [
                        'user_id' => $tutor->id,
                        'type' => 'Facebook',
                        'url' => 'https://www.facebook.com/',
                    ],
                    [
                        'user_id' => $tutor->id,
                        'type' => 'X/Twitter',
                        'url' => 'https://x.com/',
                    ],
                    [
                        'user_id' => $tutor->id,
                        'type' => 'LinkedIn',
                        'url' => 'https://www.linkedin.com/',
                    ],
                    [
                        'user_id' => $tutor->id,
                        'type' => 'Instagram',
                        'url' => 'https://www.instagram.com/',
                    ],
                    [
                        'user_id' => $tutor->id,
                        'type' => 'Pinterest',
                        'url' => 'https://www.pinterest.com/',
                    ],
                    [
                        'user_id' => $tutor->id,
                        'type' => 'YouTube',
                        'url' => 'https://www.youtube.com/',
                    ],
                    [
                        'user_id' => $tutor->id,
                        'type' => 'TikTok',
                        'url' => 'https://www.tiktok.com/',
                    ],
                ]);
            }
        }
    }
}
