<?php

namespace App\Http\Controllers;

use App\Models\EntityAttribute;
use App\Http\Requests\StoreEntityAttributeRequest;
use App\Http\Requests\UpdateEntityAttributeRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EntityAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pageSize = 20): JsonResponse
    {
        if ($pageSize > 500) {
            return response()
                ->json([
                    'message' => 'Page size must be less than or equal to 500'
                ], Response::HTTP_BAD_REQUEST);
        }

        $attributes = EntityAttribute::query()
            ->paginate(10);

        if ($attributes->isEmpty()) {
            return response()
                ->json([
                    'message' => '$No attributes found'
                ], Response::HTTP_NO_CONTENT);
        }

        return response()
            ->json([
                'data' => $attributes,
                'message' => '$success fetching attributes'
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntityAttributeRequest $request): JsonResponse
    {
        $entityAttribute = EntityAttribute::query()
            ->create($request->validated());

        return response()
            ->json([
                'data' => $entityAttribute,
                'message' => 'success creating Entity attribute',
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(EntityAttribute $entityAttribute): JsonResponse
    {
        return response()
            ->json([
                'data' => $entityAttribute,
                'message' => 'success fetching Entity attribute',
            ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntityAttributeRequest $request, EntityAttribute $entityAttribute): JsonResponse
    {
        $entityAttribute->update($request->validated());

        if (!$entityAttribute->wasChanged()) {
            return response()
                ->json([
                    'data' => $entityAttribute,
                    'message' => 'No changes were made',
                ]);
        }

        return response()
            ->json([
                'data' => $entityAttribute,
                'message' => 'success updating Entity attribute',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntityAttribute $entityAttribute): JsonResponse
    {
        $entityAttribute->delete();

        return response()
            ->json([
                'data' => $entityAttribute,
                'message' => 'success deleting Entity attribute',
            ]);
    }
}
