<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pets",
     *     summary="Get all pets",
     *     tags={"Pets"},
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index()
    {
        $pets = Pet::all();
        return $this->successResponse($pets);
    }

    /**
     * @OA\Get(
     *     path="/api/pets/{id}",
     *     summary="Get a specific pet by ID",
     *     tags={"Pets"},
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
    public function show($id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return $this->errorResponse('Pet not found', 404);
        }

        return $this->successResponse($pet);
    }

    /**
     * @OA\Post(
     *     path="/api/pets",
     *     summary="Create a new pet",
     *     tags={"Pets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "species", "gender"},
     *             @OA\Property(property="name", type="string", example="Buddy"),
     *             @OA\Property(property="species", type="string", example="Dog"),
     *             @OA\Property(property="breed", type="string", example="Golden Retriever"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="2020-01-01"),
     *             @OA\Property(property="gender", type="string", enum={"male", "female", "unknown"}, example="male"),
     *             @OA\Property(property="weight", type="number", format="float", example=30.5)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Pet created successfully"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:male,female,unknown',
            'weight' => 'nullable|numeric',
        ]);

        $pet = Pet::create($validated);

        return $this->successResponse($pet, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/pets/{id}",
     *     summary="Update pet information",
     *     tags={"Pets"},
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
     *             @OA\Property(property="name", type="string", example="Buddy Updated"),
     *             @OA\Property(property="species", type="string", example="Dog"),
     *             @OA\Property(property="breed", type="string", example="Golden Retriever"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="2020-01-01"),
     *             @OA\Property(property="gender", type="string", enum={"male", "female", "unknown"}, example="male"),
     *             @OA\Property(property="weight", type="number", format="float", example=32.0)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pet updated successfully"),
     *     @OA\Response(response=404, description="Pet not found"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function update(Request $request, $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return $this->errorResponse('Pet not found', 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'species' => 'sometimes|required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'sometimes|required|in:male,female,unknown',
            'weight' => 'nullable|numeric',
        ]);

        $pet->update($validated);

        return $this->successResponse($pet);
    }

    /**
     * @OA\Delete(
     *     path="/api/pets/{id}",
     *     summary="Delete a pet",
     *     tags={"Pets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the pet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pet deleted successfully"),
     *     @OA\Response(response=404, description="Pet not found")
     * )
     */
    public function destroy($id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return $this->errorResponse('Pet not found', 404);
        }

        $pet->delete();

        return $this->successResponse(['message' => 'Pet deleted successfully']);
    }
}