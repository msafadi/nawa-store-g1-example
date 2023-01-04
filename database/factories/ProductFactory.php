<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = ['active', 'draft', 'archived'];
        $name = $this->faker->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => Category::inRandomOrder()->limit(1)->value('id'),
            'image_path' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 1, 999),
            'compare_price' => $this->faker->randomFloat(2, 999, 9999),
            'quantity' => $this->faker->randomNumber(3),
            'status' => $status[rand(0, 2)],
            'featured' => rand(0, 1),
            'reviews_count' => $this->faker->randomNumber(3),
            'reviews_avg' => $this->faker->randomFloat(2, 0, 5),
        ];
    }
}
