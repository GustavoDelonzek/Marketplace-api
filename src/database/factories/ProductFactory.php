<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'category_id' => $this->faker->randomElement(Category::all()->pluck('id')->toArray()),
            'stock' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(1, 1000),
            'image_path' => 'public/products/defaultProduct.png',
        ];
    }
}
