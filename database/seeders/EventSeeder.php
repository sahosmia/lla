<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'HS Code Risk, Shipping Guarantee & BTB LC – Case Study Session',
                'date_time' => 'Saturday, 17 January 2026, 9:00 PM (BST)',
                'mode' => 'Online (Live Session)',
                'trainer_name' => 'Mohammad Rafiqul Islam (VP & Head of Export Operations, Prime Bank PLC)',
                'registration_link' => '#',
            ],
            [
                'title' => 'Fundamentals of International Trade – Certificate Course',
                'date_time' => 'To be announced',
                'mode' => 'Online / Classroom',
                'trainer_name' => 'Mohammad Rafiqul Islam',
                'registration_link' => '#',
            ],
            [
                'title' => 'Documentary Credits (UCP 600 & ISBP 821) – Practical Training',
                'date_time' => 'To be announced',
                'mode' => 'Online / Physical',
                'trainer_name' => 'Mohammad Rafiqul Islam',
                'registration_link' => '#',
            ],
            [
                'title' => 'Trade Finance Compliance & TBML – Risk-Based Approach',
                'date_time' => 'To be announced',
                'mode' => 'Online',
                'trainer_name' => 'Mohammad Rafiqul Islam',
                'registration_link' => '#',
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(['title' => $event['title']], $event);
        }
    }
}
