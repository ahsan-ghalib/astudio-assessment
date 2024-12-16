<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pageSize = 20)
    {
        if ($pageSize > 500) {
            return response()
                ->json([
                    'message' => 'Page size must be less than or equal to 500'
                ], Response::HTTP_BAD_REQUEST);
        }

        $projects = Project::query()
            ->with([
                'attributesValues.attribute'
            ])
            ->paginate($pageSize);

        if ($projects->isEmpty()) {
            return response()
                ->json([
                    'message' => 'No projects found'
                ], Response::HTTP_NO_CONTENT);
        }

        return response()
            ->json([
                'data' => $projects,
                'message' => 'success fetching projects'
            ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();
        try {
            DB::beginTransaction();
            $project = Project::query()
                ->create($validatedData);

            if ($request->has('attributes')) {
                $attributes = array_map(function ($attribute) use ($project) {
                    return [
                        'project_id' => $project->id,
                        'attribute_id' => $attribute['id'],
                        'value' => $attribute['value']
                    ];
                }, $validatedData['attributes']);

                $project->attributesValues()
                    ->insert($attributes);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return response()
                ->json([
                    'data' => null,
                    'message' => $exception->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()
            ->json([
                'data' => $project,
                'message' => 'success creating project',
            ], Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return response()
            ->json([
                'data' => $project->load([
                    'attributesValues.attribute'
                ]),
                'message' => 'success fetching project',
            ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validatedData = $request->validated();
        try {
            DB::beginTransaction();
            $project->update($validatedData);

            if ($request->has('attributes')) {
                $attributes = array_map(function ($attribute) use ($project) {
                    return [
                        'project_id' => $project->id,
                        'entity_attribute_id' => $attribute['id'],
                        'value' => $attribute['value']
                    ];
                }, $validatedData['attributes']);

                $project->attributesValues()
                    ->upsert($attributes, ['project_id', 'entity_attribute_id']);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return response()
                ->json([
                    'data' => null,
                    'message' => $exception->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()
            ->json([
                'data' => $project,
                'message' => 'success updating project',
            ], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            DB::beginTransaction();

            $project->attributesValues()
                ->delete();

            $project->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return response()
                ->json([
                    'data' => null,
                    'message' => $exception->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()
            ->json([
                'data' => $project,
                'message' => 'success deleting project',
            ], Response::HTTP_OK);
    }
}
