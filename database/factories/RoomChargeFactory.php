<?php

namespace Database\Factories;

use App\Models\RoomCharge;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomChargeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoomCharge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->word,
        'accommodation_id' => $this->faker->randomDigitNotNull,
        'charge_type' => $this->faker->word,
        'description' => $this->faker->word,
        'amount' => $this->faker->randomDigitNotNull,
        'payed' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
