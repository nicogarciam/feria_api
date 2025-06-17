<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hotel_id' => $this->faker->randomDigitNotNull,
        'date_from' => $this->faker->word,
        'date_to' => $this->faker->word,
        'description' => $this->faker->word,
        'limit_discount' => $this->faker->randomDigitNotNull,
        'accommodation_type_id' => $this->faker->randomDigitNotNull,
        'discount' => $this->faker->randomDigitNotNull,
        'active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
