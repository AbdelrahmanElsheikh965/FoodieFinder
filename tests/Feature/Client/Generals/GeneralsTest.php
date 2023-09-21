<?php

namespace Tests\Feature\Client\Generals;

use App\Models\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GeneralsTest extends TestCase
{
    use DatabaseTransactions;
    protected $client;
    protected $token;
    public function setUp(): void
    {
        Parent::setUp();
        $this->client = Client::factory()->create();
    }

    public function a_client_can_see_offers()
    {
        $this->actingAs($this->client)
            ->get('/api/client/offers')
            ->assertStatus(200)
            ->assertSee('test offer');
    }

}
