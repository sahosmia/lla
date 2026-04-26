<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the 'tutor' role exists
        $tutorRole = Role::firstOrCreate(['name' => 'tutor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        $trainer = User::whereHas('roles', function($q) {
            $q->where('name', 'tutor');
        })->first();
        
        if (!$trainer) {
            $trainer = User::where('email', 'trainer@example.com')->first();
            if (!$trainer) {
                $trainer = User::create([
                    'email' => 'trainer@example.com',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'status' => 1,
                ]);
            }
            $trainer->assignRole($tutorRole);
            if (!$trainer->profile) {
                $trainer->profile()->create([
                    'first_name' => 'Mohammad Rafiqul',
                    'last_name' => 'Islam',
                    'slug' => 'mohammad-rafiqul-islam',
                ]);
            }
        }

        $events = [
            [
                'title' => 'HS Code Risk, Shipping Guarantee & BTB LC – Case Study Session',
                'date_time' => 'Saturday, 17 January 2026, 9:00 PM (BST)',
                'sort_date' => '2026-01-17 21:00:00',
                'mode' => 'Online (Live Session)',
                'user_id' => $trainer->id,
            ],
            [
                'title' => 'Fundamentals of International Trade – Certificate Course',
                'date_time' => 'To be announced',
                'sort_date' => null,
                'mode' => 'Online / Classroom',
                'user_id' => $trainer->id,
            ],
            [
                'title' => 'Documentary Credits (UCP 600 & ISBP 821) – Practical Training',
                'date_time' => 'To be announced',
                'sort_date' => null,
                'mode' => 'Online / Physical',
                'user_id' => $trainer->id,
            ],
            [
                'title' => 'Trade Finance Compliance & TBML – Risk-Based Approach',
                'date_time' => 'To be announced',
                'sort_date' => null,
                'mode' => 'Online',
                'user_id' => $trainer->id,
            ],
        ];

        foreach ($events as $event) {
            if (!Event::where('title', $event['title'])->exists()) {
                Event::create($event);
            }
        }
    }
}
