<?php

namespace Tests\Feature\Place;

use App\Helpers\PlaceHelper;
use App\Models\Place;
use Illuminate\Support\Facades\Route;
use Mockery;
use Tests\TestCase;

class PlaceCreateTest extends TestCase
{
    private const ROUTE = 'places.store';

    public function test_route_exists(): void
    {
        $this->assertTrue(Route::has(self::ROUTE));
    }

    public function test_required_fields(): void
    {
        $response = $this->postJson(route(self::ROUTE));

        $response
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'name' => [
                        'The name field is required.',
                    ],
                    'city' => [
                        'The city field is required.',
                    ],
                    'state' => [
                        'The state field is required.',
                    ]
                ]
            ]);
    }

    public function test_fields_type_failed(): void
    {
        $payload = [
            'name' => ['A'],
            'city' => ['A'],
            'state' => ['A']
        ];

        $response = $this->postJson(route(self::ROUTE), $payload);

        $response
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'name' => [
                        'The name field must be a string.',
                    ],
                    'city' => [
                        'The city field must be a string.',
                    ],
                    'state' => [
                        'The state field must be a string.',
                    ]
                ]
            ]);
    }

    public function test_it_can_create_a_place(): void
    {
        $payload = Place::factory()->make()->toArray();
        $payload['slug'] = 'teste';

        $this->instance(
            PlaceHelper::class,
            Mockery::mock(PlaceHelper::class, function ($mock) use ($payload) {
                $mock->shouldReceive('slug')
                    ->once()
                    ->with($payload['name'], $payload['city'], $payload['state'])
                    ->andReturn($payload['slug']);
            })
        );

        $response = $this->postJson(route(self::ROUTE), $payload);

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $payload['name'],
                    'slug' => $payload['slug'],
                    'city' => $payload['city'],
                    'state' => $payload['state'],
                ]
            ]);

        $this->assertDatabaseHas('places', [
            'name' => $payload['name'],
            'slug' => $payload['slug'],
            'city' => $payload['city'],
            'state' => $payload['state'],
        ]);
    }

    public function test_it_can_create_a_place_with_a_generated_slug(): void
    {
        $payload = Place::factory()->make()->toArray();
        $payload['slug'] = app(PlaceHelper::class)->slug($payload['name'], $payload['city'], $payload['state']);

        $response = $this->postJson(route(self::ROUTE), $payload);

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $payload['name'],
                    'slug' => $payload['slug'],
                    'city' => $payload['city'],
                    'state' => $payload['state'],
                ]
            ]);

        $this->assertDatabaseHas('places', [
            'name' => $payload['name'],
            'slug' => $payload['slug'],
            'city' => $payload['city'],
            'state' => $payload['state'],
        ]);
    }
}
