<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pay_date' => $this->faker->word,
        'booking_id' => $this->faker->randomDigitNotNull,
        'note' => $this->faker->word,
        'amount' => $this->faker->randomDigitNotNull,
        'discount' => $this->faker->randomDigitNotNull,
        'total' => $this->faker->randomDigitNotNull,
        'coupon_code' => $this->faker->word,
        'payment_type_id' => $this->faker->randomDigitNotNull,
        'payment_state_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
