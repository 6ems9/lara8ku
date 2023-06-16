<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(3),
            'excerpt' => $this->faker->paragraph(),
            'body' => $this->faker->paragraphs(3, true),
            'user_id' => $this->faker->randomDigitNotNull(),
            'category_id' => $this->faker->randomDigitNotNull()
        ];
    }
}
