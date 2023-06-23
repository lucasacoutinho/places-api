<?php

namespace Tests\Unit\Place;

use App\Models\Place;
use App\Repository\PlaceRepositoryInterface;
use App\Services\PlaceService;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class PlaceDeleteTest extends TestCase
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

    public function test_it_expect_to_delete_a_place(): void
    {
        /** @var MockObject|PlaceRepositoryInterface $placeRepositoryMock */
        $placeRepositoryMock = $this->createMock(PlaceRepositoryInterface::class);

        $place = $this->getPlace();

        Cache::shouldReceive('forget')
            ->once()
            ->with(PlaceService::CACHE_KEY . $place->id);

        $placeRepositoryMock
            ->expects($this->once())
            ->method('deleteById')
            ->with($place->id)
            ->willReturn(true);

        $service = new PlaceService(
            $placeRepositoryMock
        );

        $service->deleteById($place->id);
    }
}
