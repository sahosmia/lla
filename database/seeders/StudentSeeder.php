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
                'email'         => 'student@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Sarah',
                'last_name'     => 'Chapman',
                'gender'        => 'female',
                'image'         => 'student-1.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [22, 23],
                'native_language' => 'Georgian',
                'address'       => [
                    'country_id'   => 1,
                    'state_id'     => 2,
                    'city'         => 'Kabul',
                    'address'      => '123 Main St',
                    'zipcode'      => '10001',
                    'lat'          => 40.712776,
                    'long'         => -74.005974
                ],
            ],
            [ // 18 M
                'email'         => 'coleman@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Ann',
                'last_name'     => 'Coleman',
                'gender'        => 'male',
                'image'         => 'student-2.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [8, 25],
                'native_language' => 'German',
                'address'       => [
                    'country_id'   => 7,
                    'state_id'     => 3,
                    'city'         => 'Jomala',
                    'address'      => '456 Broadway',
                    'zipcode'      => '10012',
                    'lat'          => 40.712776,
                    'long'         => -74.005974
                ],
            ],
            [ // 19 F
                'email'         => 'dixon@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Judy',
                'last_name'     => 'Dixon',
                'gender'        => 'female',
                'image'         => 'student-3.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [30, 32],
                'native_language' => 'Greek',
                'address'       => [
                    'country_id'   => 3,
                    'state_id'     => 1,
                    'city'         => 'Berat',
                    'address'      => '789 Oxford St',
                    'zipcode'      => 'W1D 1BS',
                    'lat'          => 51.507351,
                    'long'         => -0.127758
                ],
            ],
            [ // 20 F
                'email'         => 'elizbeth@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Elizbeth',
                'last_name'     => 'Quillen',
                'gender'        => 'female',
                'image'         => 'student-4.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [15, 16],
                'native_language' => 'Guarani',
                'address'       => [
                    'country_id'   => 4,
                    'state_id'     => 2,
                    'city'         => 'Annaba',
                    'address'      => '101 George St',
                    'zipcode'      => '2000',
                    'lat'          => -33.868820,
                    'long'         => 151.209296
                ],
            ],
            [ // 21 M
                'email'         => 'arick@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Arick',
                'last_name'     => 'Awa',
                'gender'        => 'male',
                'image'         => 'student-5.jpg',
                'description'   => '',
                'verified_at'   =>  null,
                'languages'     => [19, 20],
                'native_language' => 'Gujarati',
                'address'       =>  [
                    'country_id'   => 5,
                    'state_id'     => 6,
                    'city'         => 'Annaba',
                    'address'      => '202 Shibuya',
                    'zipcode'      => '150-0001',
                    'lat'          => 35.689487,
                    'long'         => 139.691711
                ],
            ],
            [ // 22 F
                'email'         => 'filomena@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Filomena',
                'last_name'     => 'Galicia',
                'gender'        => 'female',
                'image'         => 'student-6.jpg',
                'description'   => '',
                'verified_at'   =>  null,
                'languages'     => [17, 19],
                'native_language' => 'Hausa',
                'address'       =>  [
                    'country_id'   => 6,
                    'state_id'     => 3,
                    'city'         => 'Canillo',
                    'address'      => '303 Champs-Élysées',
                    'zipcode'      => '75008',
                    'lat'          => 48.856614,
                    'long'         => 2.352222
                ],
            ],
            [ // 23 M
                'email'         => 'ford@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Steven',
                'last_name'     => 'Ford',
                'gender'        => 'male',
                'image'         => 'student-7.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [21, 24],
                'native_language' => 'Hawaiian',
                'address'       =>  [
                    'country_id'   => 7,
                    'state_id'     => 1,
                    'city'         => 'Cacuaco',
                    'address'      => '404 Alexanderplatz',
                    'zipcode'      => '10178',
                    'lat'          => 52.520008,
                    'long'         => 13.404954
                ],
            ],
            [ // 24 F
                'email'         => 'gilberte@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Gilberte',
                'last_name'     => 'Kreger',
                'gender'        => 'female',
                'image'         => 'student-8.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [11, 22],
                'native_language' => 'Hindi',
                'address'       =>  [
                    'country_id'   => 8,
                    'state_id'     => 2,
                    'city'         => 'West End',
                    'address'      => '505 Red Square',
                    'zipcode'      => '109012',
                    'lat'          => 55.755825,
                    'long'         => 37.617298
                ],
            ],
            [ // 25 M
                'email'         => 'james@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Louis',
                'last_name'     => 'James',
                'gender'        => 'male',
                'image'         => 'student-9.jpg',
                'description'   => '',
                'verified_at'   =>  null,
                'languages'     => [14, 16],
                'native_language' => 'Bengali',
                'address'       =>  [
                    'country_id'   => 9,
                    'state_id'     => 2,
                    'city'         => 'Davis Station',
                    'address'      => '606 Sheikh Zayed Rd',
                    'zipcode'      => '00000',
                    'lat'          => 25.204849,
                    'long'         => 55.270782
                ],
            ],
            [ // 26 F
                'email'         => 'isobel@amentotech.com',
                'password'      => 'google',
                'first_name'    => 'Isobel',
                'last_name'     => 'Jones',
                'gender'        => 'female',
                'image'         => 'student-10.jpg',
                'description'   => '',
                'verified_at'   =>  now(),
                'languages'     => [19, 17],
                'native_language' => 'Asturian',
                'address'       =>  [
                    'country_id'   => 10,
                    'state_id'     => 3,
                    'city'         => 'Liberta',
                    'address'      => '707 Marine Drive',
                    'zipcode'      => '400002',
                    'lat'          => 19.076090,
                    'long'         => 72.877426
                ],
            ],
        ];

        foreach ($students as $studentData) {
            if (!isDemoSite() && $studentData['email'] == 'elizbeth@amentotech.com') {
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
