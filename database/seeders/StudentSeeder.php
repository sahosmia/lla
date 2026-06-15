<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CountryState;
use App\Models\FavouriteUser;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserSubjectGroup;
use App\Models\UserSubjectGroupSubject;

use Faker\Generator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $students = [
            [ // 17 F
                'email'         => 'student@gmail.com',
                'password'      => '12345678',
                'first_name'    => 'Sarah',
                'last_name'     => 'Chapman',
                'gender'        => 'female',
                'image'         => 'student-1.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [1, 2],
                'native_language' => 'Bengali',
                'address'       => [
                    'country_id'   => 19,
                    'state_id'     => 2,
                    'city'         => 'Kabul',
                    'address'      => '123 Main St',
                    'zipcode'      => '10001',
                    'lat'          => 40.712776,
                    'long'         => -74.005974
                ],
            ],
            [ // 18 M
                'email'         => 'coleman@gmail.com',
                'password'      => '12345678',
                'first_name'    => 'Ann',
                'last_name'     => 'Coleman',
                'gender'        => 'male',
                'image'         => 'student-2.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [1, 2],
                'native_language' => 'Bengali',
                'address'       => [
                    'country_id'   => 19,
                    'state_id'     => 3,
                    'city'         => 'Dhaka',
                    'address'      => '456 Broadway',
                    'zipcode'      => '10012',
                    'lat'          => 40.712776,
                    'long'         => -74.005974
                ],
            ],
            [ // 19 F
                'email'         => 'dixon@gmail.com',
                'password'      => '12345678',
                'first_name'    => 'Judy',
                'last_name'     => 'Dixon',
                'gender'        => 'female',
                'image'         => 'student-3.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [1, 2],
                'native_language' => 'Bengali',
                'address'       => [
                    'country_id'   => 19,
                    'state_id'     => 1,
                    'city'         => 'Dhaka',
                    'address'      => '789 Oxford St',
                    'zipcode'      => 'W1D 1BS',
                    'lat'          => 51.507351,
                    'long'         => -0.127758
                ],
            ],
            [ // 20 F
                'email'         => 'elizbeth@gmail.com',
                'password'      => '12345678',
                'first_name'    => 'Elizbeth',
                'last_name'     => 'Quillen',
                'gender'        => 'female',
                'image'         => 'student-4.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [1, 2],
                'native_language' => 'Bengali',
                'address'       => [
                    'country_id'   => 19,
                    'state_id'     => 2,
                    'city'         => 'Dhaka',
                    'address'      => '101 George St',
                    'zipcode'      => '2000',
                    'lat'          => -33.868820,
                    'long'         => 151.209296
                ],
            ],
            [ // 21 M
                'email'         => 'arick@gmail.com',
                'password'      => '12345678',
                'first_name'    => 'Arick',
                'last_name'     => 'Awa',
                'gender'        => 'male',
                'image'         => 'student-5.jpg',
                'description'   => '',
                'verified_at'   =>  null,
                'languages'     => [1, 2],
                'native_language' => 'Bengali',
                'address'       =>  [
                    'country_id'   => 19,
                    'state_id'     => 6,
                    'city'         => 'Dhaka',
                    'address'      => '202 Shibuya',
                    'zipcode'      => '150-0001',
                    'lat'          => 35.689487,
                    'long'         => 139.691711
                ],
            ],
        ];

        foreach ($students as $studentData) {
            if (!isDemoSite() && $studentData['email'] == 'elizbeth@gmail.com') {
                break;
            }
            $student = User::updateOrCreate(
                ['email' => $studentData['email']],
                [
                    'password'          => Hash::make($studentData['password']),
                    'default_role'      => 'student',
                    'email_verified_at' => now()
                ]
            );

            $profileImage = $this->storeProfileImage($studentData);

            $student->profile()->updateOrCreate(
                ['user_id' => $student->id],
                [
                    'first_name'        => $studentData['first_name'],
                    'last_name'         => $studentData['last_name'],
                    'slug'              => Str::slug($studentData['first_name'] . ' ' . $studentData['last_name'] . ' ' . $student->id),
                    'gender'            => $studentData['gender'],
                    'image'             => $profileImage,
                    'intro_video'       => $studentData['intro_video'] ?? null,
                    'description'       => $studentData['description'] ?? '',
                    'native_language'   => $studentData['native_language'] ?? null,
                    'verified_at'       => $studentData['verified_at'] ?? null,
                ]
            );

            if (!empty($studentData['languages'])) {
                $student->languages()->detach();
                $languages = [];
                foreach ($studentData['languages'] as $langId) {
                    $languages[] = $langId;
                }
                $student->languages()->attach($languages);
            }

            if (isset($studentData['address'])) {
                $this->seedAddress($student, $studentData['address']);
            }

            $student->assignRole('student');
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function storeProfileImage($studentData)
    {
        $imageFileName  = $studentData['image'] ?? '';
        $profileImage   = 'profile_images/' . Str::slug($studentData['first_name'] . ' ' . $studentData['last_name']) . '.jpg';
        $imagePath      = public_path('demo-content/student/' . $imageFileName);
        if (!empty($studentData['image']) && file_exists($imagePath)) {
            Storage::disk(getStorageDisk())->put(
                $profileImage,
                file_get_contents($imagePath)
            );
        } else {
            Storage::disk(getStorageDisk())->put(
                $profileImage,
                file_get_contents(public_path('demo-content/placeholders/placeholder.png'))
            );
        }
        return $profileImage;
    }

    public function seedAddress($student, $addressData)
    {
        if (!empty($addressData)) {
            $student->address()->create([
                'country_id'   => $addressData['country_id'] ?? null,
                'state_id'     => $addressData['state_id'] ?? null,
                'city'         => $addressData['city'] ?? '',
                'address'      => $addressData['address'] ?? '',
                'zipcode'      => $addressData['zipcode'] ?? '',
                'lat'          => $addressData['lat'] ?? 0,
                'long'         => $addressData['long'] ?? 0
            ]);
        }
    }
}
