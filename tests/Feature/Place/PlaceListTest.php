<?php

namespace Tests\Feature\Place;

use App\Models\Place;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PlaceListTest extends TestCase
{
    private const ROUTE = 'places.index';

    public function test_route_exists(): void
    {
        $this->assertTrue(Route::has(self::ROUTE));
    }

    public function test_it_should_return_empty_results_when_place_doesnt_exist(): void
    {
        $response = $this->getJson(route(self::ROUTE));

        $response
            ->assertOk()
            ->assertJson(['data' => []]);

        $this->assertDatabaseCount('places', 0);
    }

    public function test_it_should_return_results_when_places_exist(): void
    {
        $place = Place::factory()->create();

        $response = $this->getJson(route(self::ROUTE));

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $place->id,
                        'name' => $place->name,
                        'slug' => $place->slug,
                        'city' => $place->city,
                        'state' => $place->state,
                    ]
                ],
            ]);

        $this->assertDatabaseCount('places', 1);
    }

    public function test_it_should_return_filter_places_by_name_when_has_name_querystring(): void
    {
        $place = Place::factory()->create();
        Place::factory()->create();

        $response = $this->getJson(route(self::ROUTE, [
            'name' => $place->name
        ]));

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $place->id,
                        'name' => $place->name,
                        'slug' => $place->slug,
                        'city' => $place->city,
                        'state' => $place->state,
                    ]
                ],
            ], true);

        $this->assertDatabaseCount('places', 2);
    }

    public function test_it_should_return_limited_number_of_items(): void
    {
        Place::factory(5)->create();

        $response = $this->getJson(route(self::ROUTE, ['per_page' => 1]));

        $response
            ->assertOk()
            ->assertJson([
                'meta' => [
                    'per_page' => 1,
                    'total' => 5,
                ],
            ], true);

        $this->assertDatabaseCount('places', 5);
    }
}
