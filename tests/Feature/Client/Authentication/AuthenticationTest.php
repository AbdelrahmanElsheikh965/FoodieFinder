<?php

namespace Tests\Feature\Client\Authentication;

use App\Models\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    // Red (Make it fail) - Green (Make it pass) - Blue (Make it better [Refactor])
    // Tester's job isn't to find bugs but, to make sure that there are no bugs.
    // Naming Convention should be 'snake case' as PHPUnit converts _ to space.
    // Unit testing is more about [verification] while QC is more about [validation].
    /* @ means annotation
     * 1-> Setup     = Given
     * 2-> Exercise  = When
     * 3-> Verify    = Then
     */
//    use DatabaseTransactions;
    protected $client;
    protected $token;
    public function setUp(): void
    {
        Parent::setUp();
        $this->client = Client::factory()->create();
    }

    public function an_authenticated_client_can_access_profile()
    {
        // Setup
        $this->actingAs($this->client,'api')->withHeaders([
            'Accept' => 'application/json'
        ]);
        $this->token = $this->client->createToken('token')->plainTextToken;
        $data = [
            'name' => 'new_Test_Acc_Name',
            'email' => 'mailmail'
        ];

        // Exercise
        $this->post('/api/client/profile', $data, [
            'Authorization' => 'Bearer ' . $this->token
        ])
            // Verify
            ->assertStatus(200);
    }

    public function an_authenticated_client_can_create_order_and_receive_notification()
    {
        // Given
        $this->be($this->client, 'api');
        $this->token = $this->client->createToken('token')->plainTextToken;
        $data = [
            "restaurant_id" => 1,
            "payment" =>  "cash",
            "meals" =>  [
                [
                    "meal_id" =>  1,
                    "quantity" =>  2,
                    "notes" =>  "add pepsi"
                ]
            ]
        ];
        // when
        $this->post('/api/client/create-order', $data,[
            'Authorization'  => 'Bearer ' . $this->token,
            'Accept' => 'Application/json'
        ])

            // Then
            ->assertOk();
        $this->assertDatabaseHas('notifications', [
            'content' => 'Your Order has been created right now'
        ]);
    }

    public function an_authenticated_client_can_deliver_his_order()
    {
        // Setup - Requires 'DatabaseTransactions' to be disabled
        $this->actingAs($this->client,'api')->withHeaders([
            'Accept' => 'application/json'
        ]);
        $this->token = $this->client->createToken('token')->plainTextToken;
        # How to pass vars in the body of the request - shouldn't be explicitly in the test
        $data = [
            'id' => 51,
            'client_id' => 79
        ];

        // Exercise
        $this->post('/api/client/deliver/', $data, [
            'Authorization' => 'Bearer ' . $this->token
        ])
        // Verify
        ->assertOk();
    }

    public function an_authenticated_client_can_read_notifications()
    {
        Sanctum::actingAs($this->client, [], 'api');
        $this->token = $this->client->createToken('token')->plainTextToken;

        $response = $this->get('/api/client/client-notification', [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(200);
    }

    public function an_authenticated_client_can_add_a_review()
    {
        // Given
        $this->be($this->client, 'api');
        $this->token = $this->client->createToken('token')->plainTextToken;

        $data = [
            'content' => 'UnauthenticationTest Review with PHPUnit',
            'restaurant_id' => 1,
            'rate'  => 5
        ];
//
//        $this->withHeaders([
//              'Accept' => 'Application/json'
//        ]);
        # All Headers can be passed as a second argument to the endpoint uri
        # as it behaves like ->withHeaders()
        // When
        $this->post('api/client/add-review', $data, [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'Application/json'      // can be done by ->withHeaders()
        ]);

        # Then | check if table of `reviews` has that recently added value?
        $this->assertDatabaseHas('reviews', [
            'content' => 'UnauthenticationTest Review with PHPUnit'
        ]);
    }



}

