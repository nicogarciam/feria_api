<?php

namespace Tests\Feature;

use App\Http\Controllers\API\SaleAPIController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingCode extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function generateBookingCode()
    {
        $bookinController = new SaleAPIController();

        $booking = $bookinController->generateCode(1);

    }
}
