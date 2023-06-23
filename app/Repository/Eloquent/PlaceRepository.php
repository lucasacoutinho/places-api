<?php

namespace App\Repository\Eloquent;

use App\Models\Place;
use App\Repository\PlaceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{
    protected $model;

    public function __construct(Place $model)
    {
        $this->model = $model;
    }

    public function getByName(
        array $columns = ['*'],
        int $perPage = 10,
        ?string $name = null,
    ): LengthAwarePaginator {
        return $this
            ->model
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->paginate(
                columns: $columns,
                perPage: $perPage,
            );
    }
}
