<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Google\Client;
use Mockery\MockInterface;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->authUser();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_connect_to_a_service_and_token_is_stored()
    {
        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive('setScopes')->once();
            $mock->shouldReceive('createAuthUrl')->once()->andReturn('http://localhost');
        });
        $response = $this->getJson(route('service.connect', 'google-drive'))->assertOk()->json();
        $this->assertEquals('http://localhost', $response['url']);
        $this->assertNotNull($response['url']);
    }

    public function test_service_callback_will_store_token()
    {
        $this->mock(Client::class, function (MockInterface $mock) {
            /* $mock->shouldReceive('setClientId')->once();
            $mock->shouldReceive('setClientSecret')->once();
            $mock->shouldReceive('setRedirectUri')->once(); */
            $mock->shouldReceive('fetchAccessTokenWithAuthCode')->once()->andReturn(['access_token' => 'fake-token']);
        });
        $response = $this->postJson(route('service.callback'), ['code' => 'dummyCode'])->assertCreated();
        //$webService = Service::first();
        $this->assertDatabaseHas('services', ['user_id' => $this->user->id, 'token' => json_encode(['access_token' => 'fake-token'])]);
        //$this->assertNotNull($this->user->services->first()->token);
    }

    public function test_data_of_week_can_be_stored_on_google_drive()
    {
        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive('setAccessToken');
            $mock->shouldReceive('getLogger->info');
            $mock->shouldReceive('shouldDefer');
            $mock->shouldReceive('execute');
        });

        $this->createTask(['created_at' => now()->subDays(1)]);
        $this->createTask(['created_at' => now()->subDays(2)]);
        $this->createTask(['created_at' => now()->subDays(3)]);
        $this->createTask(['created_at' => now()->subDays(4)]);
        $this->createTask(['created_at' => now()->subDays(10)]);

        $service = $this->createService();
        $this->postJson(route('service.store', $service->id))->assertCreated();
    }
}
