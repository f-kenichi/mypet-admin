<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pets/{id}/visits",
     *     summary="Get all visit records for a pet",
     *     tags={"Visits"},
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

        return $this->successResponse($pet->visits);
    }

    /**
     * @OA\Post(
     *     path="/api/pets/{id}/visits",
     *     summary="Add a new visit record",
     *     tags={"Visits"},
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
     *             required={"clinic", "reason", "date"},
     *             @OA\Property(property="clinic", type="string", example="Happy Paws Clinic"),
     *             @OA\Property(property="reason", type="string", example="Annual Checkup"),
     *             @OA\Property(property="date", type="string", format="date", example="2025-07-07")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Visit record created successfully"),
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
            'clinic' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $visit = $pet->visits()->create($validated);

        return $this->successResponse($visit, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/visits/{id}",
     *     summary="Update a visit record",
     *     tags={"Visits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the visit record",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="clinic", type="string", example="Updated Clinic"),
     *             @OA\Property(property="reason", type="string", example="Updated Reason"),
     *             @OA\Property(property="date", type="string", format="date", example="2025-07-08")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Visit record updated successfully"),
     *     @OA\Response(response=404, description="Visit not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $visit = Visit::find($id);

        if (!$visit) {
            return $this->errorResponse('Visit not found', 404);
        }

        $validated = $request->validate([
            'clinic' => 'sometimes|required|string|max:255',
            'reason' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
        ]);

        $visit->update($validated);

        return $this->successResponse($visit);
    }

    /**
     * @OA\Delete(
     *     path="/api/visits/{id}",
     *     summary="Delete a visit record",
     *     tags={"Visits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the visit record",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Visit record deleted successfully"),
     *     @OA\Response(response=404, description="Visit not found")
     * )
     */
    public function destroy($id)
    {
        $visit = Visit::find($id);

        if (!$visit) {
            return $this->errorResponse('Visit not found', 404);
        }

        $visit->delete();

        return $this->successResponse(['message' => 'Visit deleted successfully']);
    }
}