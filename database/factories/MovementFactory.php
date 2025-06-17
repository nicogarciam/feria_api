<?php

namespace Database\Factories;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->word,
        'booking_id' => $this->faker->randomDigitNotNull,
        'client_id' => $this->faker->randomDigitNotNull,
        'account_id' => $this->faker->randomDigitNotNull,
        'concept' => $this->faker->word,
        'amount' => $this->faker->randomDigitNotNull,
        'type' => $this->faker->word,
        'state' => $this->faker->word,
        'user' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
