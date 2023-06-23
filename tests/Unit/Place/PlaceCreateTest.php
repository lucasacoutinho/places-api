<?php

namespace Tests\Unit\Place;

use App\Models\Place;
use App\Repository\PlaceRepositoryInterface;
use App\Services\PlaceService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class PlaceCreateTest extends TestCase
{
    public function getPlace(): Place
    {
        return new Place([
            'name' => '51817 Dewitt Bridge',
            'city' => 'Port Joshuaberg',
            'state' => 'sint tenetur',
        ]);
    }

    public function test_it_expect_to_create_a_place(): void
    {
        /** @var MockObject|PlaceRepositoryInterface $placeRepositoryMock */
        $placeRepositoryMock = $this->createMock(PlaceRepositoryInterface::class);
        $place = $this->getPlace();
        $data = $place->toArray();

        $placeRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($place);

        $service = new PlaceService(
            $placeRepositoryMock
        );

        $service->create($data);
    }
}
