<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubjectGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class GeneralSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::firstOrCreate(['email' => 'admin@amentotech.com'], [
            'email' => 'admin@amentotech.com',
            'password' => Hash::make('google'),
            'email_verified_at' => now()
        ]);
        $admin->profile()->create(['first_name' => 'Admin', 'last_name' => 'User', 'slug' => 'admin']);

        $admin->assignRole('admin');

        SubjectGroup::truncate();
        Subject::truncate();

        SubjectGroup::insert([
            ['name' => 'Primary school (Grade 1 to 5)'],
            ['name' => 'Middle school (Grades 6-8)'],
            ['name' => 'High school (Grades 9-10)'],
            ['name' => 'Intermediate (Grades 11-12)'],
            ['name' => "Undergraduate (Bachelor's Degree)"],
            ['name' => 'Graduate (Masters Degree)'],
            ['name' => 'Post graduate (Doctoral Degree)'],
        ]);

        Subject::insert([
            ['name' => 'Web Development'], //1
            ['name' => 'Web Designing'], //2
            ['name' => 'Software Development'], //3
            ['name' => 'Software Design'], //4
            ['name' => 'UI/UX'], //5
            ['name' => 'English'], //6
            ['name' => 'Maths'], //7
            ['name' => 'Social Studies'], //8
            ['name' => 'General Knowledge'], //9
            ['name' => 'Science'], //10
            ['name' => 'Physical Education'], //11
            ['name' => 'Physics'], //12
            ['name' => 'Computer'], //13
            ['name' => 'Chemistry'] //14

        ]);

        Storage::disk(getStorageDisk())->putFileAs('', public_path('demo-content/placeholders/placeholder.png'), 'placeholder.png');
        Storage::disk(getStorageDisk())->putFileAs('', public_path('demo-content/placeholders/placeholder-land.png'), 'placeholder-land.png');
        Storage::disk(getStorageDisk())->putFileAs('', public_path('demo-content/placeholders/blog-default.png'), 'blog-default.png');
    }
}
