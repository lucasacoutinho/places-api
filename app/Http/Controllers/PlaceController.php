<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceCreateRequest;
use App\Http\Requests\PlaceListRequest;
use App\Http\Requests\PlaceUpdateRequest;
use App\Http\Resources\PlaceResource;
use App\Services\PlaceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @group Place
 */
class PlaceController extends Controller
{
    public function __construct(
        private readonly PlaceService $placeService
    ) {
    }

    /**
     * Places list
     *
     * This endpoint return the list of places.
     * @responseFile doc/place/places.json
     */
    public function index(PlaceListRequest $request): AnonymousResourceCollection
    {
        return PlaceResource::collection($this->placeService->getByName($request->validated()));
    }

    /**
     * Find place
     *
     * This endpoint return a place.
     * @urlParam id integer required The ID of the place.
     * @responseFile doc/place/place.json
     */
    public function show(int $id): PlaceResource
    {
        return PlaceResource::make($this->placeService->findById($id));
    }

    /**
     * New place
     *
     * This endpoint create a new place.
     * @responseFile doc/place/place.json
     * @responseFile 422 doc/place/createValidation.json
     */
    public function store(PlaceCreateRequest $request): PlaceResource
    {
        return PlaceResource::make($this->placeService->create($request->validated()));
    }

    /**
     * Update a place
     *
     * This endpoint update a place.
     * @urlParam id integer required The ID of the place.
     * @response {"message": "Place updated."}
     * @responseFile 422 doc/place/updateValidation.json
     */
    public function update(int $id, PlaceUpdateRequest $request): JsonResponse
    {
        $this->placeService->update($id, $request->validated());

        return response()->json(['message' => 'Place updated.']);
    }

    /**
     * Delete a place
     *
     * This endpoint delete a place.
     * @urlParam id integer required The ID of the place.
     * @response 204 {"message": "Place deleted."}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->placeService->deleteById($id);

        return response()->json(['message' => 'Place deleted.'], Response::HTTP_NO_CONTENT);
    }
}
