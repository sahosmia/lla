<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = \App\Models\Blog::class;

    public function definition()
    {
        return [
            'author_id'     => User::first()->id,
            'title'         => $this->faker->sentence,
            'description'   => $this->faker->paragraphs(3, true),
            'tags'          => $this->faker->words(3),
            'category_id'   => $this->faker->randomElement(BlogCategory::pluck('id')),
            'status'        => 'published',
        ];
    }
}
