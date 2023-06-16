<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // User
        User::create([
            'name' => 'EMS',
            'username' => '6ems9',
            'email' => 'admin@gmail.com',
            'role_id' => '1',
            'email_verified_at' => now(),
            'password' => bcrypt('password')

        ]);
        User::factory(9)->create();

        // Category
        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design'
        ]);
        Category::create([
            'name' => 'Web Developer',
            'slug' => 'web-developer'
        ]);
        Category::create([
            'name' => 'Programming',
            'slug' => 'programming'
        ]);
        Category::factory(6)->create();

        // Post
        Post::factory(125)->create();

        // Tags
        Tag::factory(10)->create();

        // Random Post_Tag
        foreach (Post::all() as $taging) {
            $tag = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $taging->tags()->attach($tag);
        }
    }
}
