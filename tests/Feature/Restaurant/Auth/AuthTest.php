<?php

namespace Tests\Feature\Restaurant\Auth;

use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Restaurant;
use phpDocumentor\Reflection\Types\Parent_;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $restaurant;
    public function setUp() : void
    {
        Parent::setUp();
        $this->restaurant = Restaurant::factory()->create();
    }
    public function test_a_restaurant_can_reset_his_forgotten_password_using_mail()
    {
        Mail::fake();
        $dataOfRestaurant = ['email' => $this->restaurant->email];
        $this->post('/api/restaurant/reset-password',$dataOfRestaurant)
                ->assertOk();
        Mail::assertSent(sendMail::class);
    }

    public function test_a_restaurant_can_create_new_password_with_pinCode()
    {
        $data = [
            'email' => $this->restaurant->email,
            'pin_code'  => $this->restaurant->pin_code,
            'password'  => 'password'
        ];
        $response = $this->post('api/restaurant/create-new-password', $data);
        $response->assertOk();
    }
}
