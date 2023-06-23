<?php

namespace Tests\Feature\Task;

use App\Models\Place;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PlaceDeleteTest extends TestCase
{
    private const ROUTE = 'places.destroy';

    public function test_route_exists(): void
    {
        $this->assertTrue(Route::has(self::ROUTE));
    }

    public function test_place_not_found(): void
    {
        $response = $this->deleteJson(route(self::ROUTE, 0));

        $response->assertNotFound();
    }

    public function test_it_can_a_place(): void
    {
        $place = Place::factory()->create();

        $response = $this->deleteJson(route(self::ROUTE, $place->id));

        $response->assertNoContent();

        $this->assertDatabaseMissing('places', [
            'id' => $place->id
        ]);
    }
}
