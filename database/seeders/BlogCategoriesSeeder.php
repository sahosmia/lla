<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogCategory::truncate();

        BlogCategory::upsert([
            ['name' => 'Technology',        'slug' => 'technology'],
            ['name' => 'Health',            'slug' => 'health'],
            ['name' => 'Travel',            'slug' => 'travel'],
            ['name' => 'Food',              'slug' => 'food'],
            ['name' => 'Lifestyle',         'slug' => 'lifestyle'],
            ['name' => 'Business',          'slug' => 'business'],
            ['name' => 'Entertainment',     'slug' => 'entertainment'],
            ['name' => 'Sports',            'slug' => 'sports'],
            ['name' => 'Science',           'slug' => 'science'],
            ['name' => 'Education',         'slug' => 'education'],
            ['name' => 'Politics',          'slug' => 'politics'],
            ['name' => 'Culture',           'slug' => 'culture'],
            ['name' => 'Art',               'slug' => 'art'],
        ], ['slug'], ['name']);
    }
}
