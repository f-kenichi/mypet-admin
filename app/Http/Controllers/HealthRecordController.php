<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\HealthRecord;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pets/{id}/health-records",
     *     summary="Get all health records for a pet",
     *     tags={"Health Records"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the pet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Pet not found")
     * )
     */
    public function index($id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return $this->errorResponse('Pet not found', 404);
        }

        return $this->successResponse($pet->healthRecords);
    }

    /**
     * @OA\Post(
     *     path="/api/pets/{id}/health-records",
     *     summary="Add a new health record",
     *     tags={"Health Records"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the pet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="weight", type="number", format="float", example=12.5),
     *             @OA\Property(property="temperature", type="number", format="float", example=38.5),
     *             @OA\Property(property="mood", type="string", example="Happy")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Health record created successfully"),
     *     @OA\Response(response=404, description="Pet not found")
     * )
     */
    public function store(Request $request, $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return $this->errorResponse('Pet not found', 404);
        }

        $validated = $request->validate([
            'weight' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'mood' => 'nullable|string|max:255',
        ]);

        $healthRecord = $pet->healthRecords()->create($validated);

        return $this->successResponse($healthRecord, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/health-records/{id}",
     *     summary="Update a health record",
     *     tags={"Health Records"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the health record",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="weight", type="number", format="float", example=13.0),
     *             @OA\Property(property="temperature", type="number", format="float", example=39.0),
     *             @OA\Property(property="mood", type="string", example="Excited")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Health record updated successfully"),
     *     @OA\Response(response=404, description="Health record not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $healthRecord = HealthRecord::find($id);

        if (!$healthRecord) {
            return $this->errorResponse('Health record not found', 404);
        }

        $validated = $request->validate([
            'weight' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'mood' => 'nullable|string|max:255',
        ]);

        $healthRecord->update($validated);

        return $this->successResponse($healthRecord);
    }

    /**
     * @OA\Delete(
     *     path="/api/health-records/{id}",
     *     summary="Delete a health record",
     *     tags={"Health Records"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the health record",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Health record deleted successfully"),
     *     @OA\Response(response=404, description="Health record not found")
     * )
     */
    public function destroy($id)
    {
        $healthRecord = HealthRecord::find($id);

        if (!$healthRecord) {
            return $this->errorResponse('Health record not found', 404);
        }

        $healthRecord->delete();

        return $this->successResponse(['message' => 'Health record deleted successfully']);
    }
}