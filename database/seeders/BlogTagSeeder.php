<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\Tag;

class BlogTagSeeder extends Seeder
{
    public function run()
    {
        BlogTag::truncate();

        $tags = [
            'Pharma',
            'COVID-19',
            'R&D',
            'Corporate Life',
            'Leadership',
            'Resilience',
            'Green Tech',
            'Sustainability',
            'Renewable Energy',
            'AI',
            'Customer Service',
            'Automation',
            'Remote Work',
            'Work-Life Balance',
            'Productivity',
            'Electric Vehicles',
            'Urban Mobility',
            'Clean Energy',
            'Mental Health',
            'Workplace',
            'Employee Well-being',
            'Cybersecurity',
            'Digital Age',
            'Data Protection',
            'Innovation',
            'Crisis Management',
            'Digital Transformation'
        ];


        foreach ($tags as $tagName) {
            BlogTag::firstOrCreate(['name' => $tagName]);
        }
    }
}
