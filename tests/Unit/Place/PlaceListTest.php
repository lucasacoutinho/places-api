<?php

namespace Tests\Unit\Task;

use App\Models\Place;
use App\Repository\PlaceRepositoryInterface;
use App\Services\PlaceService;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class PlaceListTest extends TestCase
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

    public function test_it_expect_to_list_places(): void
    {
        /** @var MockObject|PlaceRepositoryInterface $placeRepositoryMock */
        $placeRepositoryMock = $this->createMock(PlaceRepositoryInterface::class);
        $places = new LengthAwarePaginator(collect([$this->getPlace()]), 1, 1);
        $data = [];

        $placeRepositoryMock
            ->expects($this->once())
            ->method('getByName')
            ->with(['*'], 10, null)
            ->willReturn($places);

        $service = new PlaceService(
            $placeRepositoryMock
        );

        $service->getByName($data);
    }

    public function test_it_expect_to_filter_place_list(): void
    {
        /** @var MockObject|PlaceRepositoryInterface $placeRepositoryMock */
        $placeRepositoryMock = $this->createMock(PlaceRepositoryInterface::class);
        $places = new LengthAwarePaginator(collect([$this->getPlace()]), 1, 1);
        $data = ['name' => '51817 Dewitt Bridge'];

        $placeRepositoryMock
            ->expects($this->once())
            ->method('getByName')
            ->with(['*'], 10, $data['name'])
            ->willReturn($places);

        $service = new PlaceService(
            $placeRepositoryMock
        );

        $service->getByName($data);
    }
}
