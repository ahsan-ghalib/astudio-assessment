<?php

namespace App\Http\Controllers;

use App\Models\TimeSheet;
use App\Http\Requests\StoreTimeSheetRequest;
use App\Http\Requests\UpdateTimeSheetRequest;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Type\Time;
use Symfony\Component\HttpFoundation\Response;

class TimeSheetController extends Controller
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
        $timesheets = auth()->user()
            ->timeSheet()
            ->with('project')
            ->paginate();

        if ($timesheets->isEmpty()) {
            return response()
                ->json([
                    'message' => 'No projects found'
                ], Response::HTTP_NO_CONTENT);
        }

        return response()
            ->json([
                'data' => $timesheets,
                'message' => 'success fetching time sheet'
            ], Response::HTTP_OK);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimeSheetRequest $request): JsonResponse
    {
        $timeSheet = auth()->user()
            ->timeSheet()
            ->create($request->validated());

        return response()
            ->json([
                'data' => $timeSheet,
                'message' => 'success creating time sheet',
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeSheet $timeSheet): JsonResponse
    {
        if (!$this->validateTimeSheet($timeSheet)) {
            return response()
                ->json([
                    'message' => 'Time sheet does not exist',
                ], Response::HTTP_BAD_REQUEST);
        }

        return response()
            ->json([
                'data' => $timeSheet->load([
                    'project'
                ]),
                'message' => 'success fetching time sheet',
            ], Response::HTTP_CREATED);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimeSheetRequest $request, TimeSheet $timeSheet): JsonResponse
    {
        if (!$this->validateTimeSheet($timeSheet)) {
            return response()
                ->json([
                    'message' => 'Time sheet does not exist',
                ], Response::HTTP_BAD_REQUEST);
        }


        $timeSheet->update($request->validated());

        return response()
            ->json([
                'message' => 'success updating time sheet',
            ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeSheet $timeSheet): JsonResponse
    {
        if (!$this->validateTimeSheet($timeSheet)) {
            return response()
                ->json([
                    'message' => 'Time sheet does not exist',
                ], Response::HTTP_BAD_REQUEST);
        }


        $timeSheet->delete();

        return response()
            ->json([
                'message' => 'success deleting time sheet',
            ], Response::HTTP_BAD_REQUEST);
    }

    private function validateTimeSheet(TimeSheet $timeSheet): bool
    {
        $authUser = auth()->user();

        return $authUser->timeSheet()
            ->where('id', $timeSheet->id)
            ->exist();
    }
}
