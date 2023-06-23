<?php

namespace Tests\Feature\Place;

use App\Helpers\PlaceHelper;
use App\Models\Place;
use Illuminate\Support\Facades\Route;
use Mockery;
use Tests\TestCase;

class PlaceUpdateTest extends TestCase
{
    private const ROUTE = 'places.update';

    public function test_route_exists(): void
    {
        $this->assertTrue(Route::has(self::ROUTE));
    }

    public function test_fields_must_have_values(): void
    {
        $place = Place::factory()->create();
        $payload = [
            'name' => '',
            'city' => '',
            'state' => ''
        ];

        $response = $this->putJson(route(self::ROUTE, $place->id), $payload);

        $response
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'name' => [
                        'The name field must have a value.',
                    ],
                    'city' => [
                        'The city field must have a value.',
                    ],
                    'state' => [
                        'The state field must have a value.',
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

        $place = Place::factory()->create();
        $response = $this->putJson(route(self::ROUTE, $place->id), $payload);

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
        $place = Place::factory()->create();
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

        $response = $this->putJson(route(self::ROUTE, $place->id), $payload);

        $response
            ->assertOk()
            ->assertJson(['message' => 'Place updated.']);

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => $payload['name'],
            'slug' => $payload['slug'],
            'city' => $payload['city'],
            'state' => $payload['state'],
        ]);
    }

    public function test_it_can_create_a_place_with_a_generated_slug(): void
    {
        $place = Place::factory()->create();
        $payload = Place::factory()->make()->toArray();
        $payload['slug'] = app(PlaceHelper::class)->slug($payload['name'], $payload['city'], $payload['state']);

        $response = $this->putJson(route(self::ROUTE, $place->id), $payload);

        $response
            ->assertOk()
            ->assertJson(['message' => 'Place updated.']);

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => $payload['name'],
            'slug' => $payload['slug'],
            'city' => $payload['city'],
            'state' => $payload['state'],
        ]);
    }
}
