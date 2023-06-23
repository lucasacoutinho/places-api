<?php

namespace Tests\Unit\Task;

use App\Models\Place;
use App\Repository\PlaceRepositoryInterface;
use App\Services\PlaceService;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class PlaceUpdateTest extends TestCase
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

    public function test_it_expect_to_update_a_task(): void
    {
        /** @var MockObject|PlaceRepositoryInterface $placeRepositoryMock */
        $placeRepositoryMock = $this->createMock(PlaceRepositoryInterface::class);
        $place = $this->getPlace();
        $data = ['name' => '51816 Dewitt Bridge'];

        Cache::shouldReceive('forget')
            ->once()
            ->with(PlaceService::CACHE_KEY . $place->id);

        $placeRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with($place->id, $data)
            ->willReturn(true);

        $service = new PlaceService(
            $placeRepositoryMock
        );

        $service->update($place->id, $data);
    }
}
