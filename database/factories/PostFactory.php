<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'category_id' => 1,
        'post_title' => $faker->sentence,
        'post_content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos.Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta veniam animi harum laborum nemo unde sequi atque eaque quaerat distinctio. Minima maiores eveniet in hic velit at laboriosam doloribus dignissimos.',
        'post_status' => 'active',
        'post_slug' => $faker->word.'-3457',
        'post_image' => 'null',
    ];
});

