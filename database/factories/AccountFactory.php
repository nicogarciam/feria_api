<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->word,
        'lastName' => $this->faker->word,
        'activated' => $this->faker->word,
        'email' => $this->faker->word,
        'langKey' => $this->faker->word,
        'city_id' => $this->faker->randomDigitNotNull,
        'gender' => $this->faker->word,
        'imageUrl' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull
        ];
    }
}
