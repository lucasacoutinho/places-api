<?php

namespace Tests\Unit\Place;

use App\Models\Place;
use App\Repository\PlaceRepositoryInterface;
use App\Services\PlaceService;
use Closure;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

/**
 * @group unit
 */
class PlaceDetailTest extends TestCase
{
    public function getPlace(): Place
    {
        $place = new Place([
            'name' => '51817 Dewitt Bridge',
            'city' => 'Port Joshuaberg',
            'state' => 'sint tenetur',
        ]);
        $place->id = 1;

        return $place;
    }

    public function test_it_expect_to_show_a_place(): void
    {
        /** @var MockObject|PlaceRepositoryInterface $placeRepositoryMock */
        $placeRepositoryMock = $this->createMock(PlaceRepositoryInterface::class);

        $place = $this->getPlace();

        Cache::shouldReceive('get')
            ->once()
            ->with(PlaceService::CACHE_KEY . $place->id, Closure::class)
            ->andReturn($place);

        $service = new PlaceService(
            $placeRepositoryMock
        );

        $service->findById($place->id);
    }
}
