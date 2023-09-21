<?php

namespace Tests\Feature\Client\Unauthentication;

use App\Models\Client;
use Tests\TestCase;

class UnauthenticationTest extends TestCase
{
    protected $client;
    protected $token;

    public function register_a_new_client()
    {
        // Setup
        $data = [
            'name'      => 's7s',
            'email'     =>'s7s@foodiefinder.com',
            'phone'     =>'01115454544',
            'password'  =>'s7ss7ss7ss7ss7s',
            'password_confirmation'=>'s7ss7ss7ss7ss7s',
            'region_id' => 2,
            'device_token' => 'eyHOUmQgSOqtdbDYxch7ug:APA91bHkOyO2lnZwhQtQLMv-kIq1JEO1JGa84dGCS5e-BeF6yJCcyXgDMudPbpoxj6nj7gTqRtrjJcLy3pYW77udYQWyZh0tpxP953eWOXZ81YGW0q4_bAdhEaci49s4SddW1AptCAJe'
        ];

        // Exercise
        $this->post('api/client/register', $data, [
            'Accept'=> 'Application/json'
        ])
            // Verify
            ->assertOk();


    }

    public function a_client_cannot_register_with_incoreect_data()
    {
        // Setup
        $data = [
            'name'      => 's7s',
            'email'     =>'s7sfoodiefindercom',
            'phone'     =>'01115454544',
            'password'  =>'s7ss7ss7ss7s7s',
            'password_confirmation'=>'s7ss7ss7ss7ss7s',
            'region_id' => 2,
            'device_token' => 'eyHOUmQgSOqtdbDYxch7ug:APA91bHkOyO2lnZwhQtQLMv-kIq1JEO1JGa84dGCS5e-BeF6yJCcyXgDMudPbpoxj6nj7gTqRtrjJcLy3pYW77udYQWyZh0tpxP953eWOXZ81YGW0q4_bAdhEaci49s4SddW1AptCAJe'
        ];

        // Exercise
        $this->post('api/client/register', $data, [
            'Accept'=> 'Application/json'
        ])
            // Verify
            ->assertUnprocessable();


    }

    public function login_a_new_client()
    {
        // Setup
        $this->client = Client::factory()->create();
        $this->be($this->client, 'api');

        $data = [
            'email' => $this->client->email,
            'password' => $this->client->password,
        ];

        // Exercise

        $this->post('api/client/login', $data, [
            'Accept'=> 'Application/json'
        ])
        // Verify
        ->assertOk();


    }

    public function an_unauthenticated_client_cannot_access_profile()
    {
        # Setup - Given
        $this->client = Client::factory()->create();
        $this->actingAs($this->client, 'api')
            ->withHeaders([
                'Accept' => 'Application/json'
            ])
            # Exercise - When
            ->post('api/client/profile')
            # Verify - Then
            ->assertUnauthorized();
    }

    public function an_unauthenticated_client_cannot_read_notifications()
    {
        # Setup - Given
        $this->client = Client::factory()->create();
        $test = $this->actingAs($this->client, 'api');

        # Exercise - When
        $test->get('/api/client/client-notification', ['Accept' => 'application/json'])
        # Verify - Then
        ->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);
    }
}
