<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomDigitNotNull,
            'description' => $this->faker->word,
            'store_id' => 1,
            'provider_id' => 1,
            'category_id' => $this->faker->numberBetween(1,4),
            'state_id' => $this->faker->numberBetween(1,3),
            'color' => $this->faker->rgbCssColor,
            'size' => $this->faker->numberBetween(12,42),
            'price' => $this->faker->randomFloat()
        ];
    }
}
