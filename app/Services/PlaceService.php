<?php

namespace App\Services;

use App\Repository\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class PlaceService
{
    public const CACHE_KEY = 'place_';

    public function __construct(
        private PlaceRepositoryInterface $placeRepository
    ) {
    }

    public function getByName(array $data): object
    {
        $name = isset($data['name']) ? $data['name'] : null;
        $items = isset($data['per_page']) ? $data['per_page'] : 10;

        return $this->placeRepository->getByName(name: $name, perPage: $items);
    }

    public function findById(int $id): object
    {
        return Cache::get(self::CACHE_KEY . $id,  fn () => $this->placeRepository->findById($id));
    }

    public function create(array $data): object
    {
        $place = $this->placeRepository->create($data);

        return Cache::rememberForever(self::CACHE_KEY . $place->id, fn () => $place);
    }

    public function update(int $id, array $data): bool
    {
        Cache::forget(self::CACHE_KEY . $id);
        return $this->placeRepository->update($id, $data);
    }

    public function deleteById(int $id): bool
    {
        Cache::forget(self::CACHE_KEY . $id);
        return $this->placeRepository->deleteById($id);
    }
}
