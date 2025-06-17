<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hotel_id' => $this->faker->randomDigitNotNull,
        'guest_id' => $this->faker->randomDigitNotNull,
        'booking_state_id' => $this->faker->randomDigitNotNull,
        'date_in' => $this->faker->word,
        'date_out' => $this->faker->word,
        'note' => $this->faker->word,
        'pax' => $this->faker->randomDigitNotNull,
        'pax_adult' => $this->faker->randomDigitNotNull,
        'pax_minor' => $this->faker->randomDigitNotNull,
        'accommodation_count' => $this->faker->randomDigitNotNull,
        'coupon_code' => $this->faker->word,
        'days_to_confirm' => $this->faker->randomDigitNotNull,
        'days_to_cancel' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
