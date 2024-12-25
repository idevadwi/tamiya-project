<?php

namespace App\Http\Controllers;

use App\Services\RacerService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RacerController extends Controller
{
    protected RacerService $racerService;

    public function __construct(RacerService $racerService)
    {
        $this->racerService = $racerService;
    }

    /**
     * @OA\Get(
     *     path="/api/racers",
     *     summary="Get all racers",
     *     tags={"Racers"},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        return response()->json($this->racerService->getAllRacers());
    }

    /**
     * @OA\Post(
     *     path="/api/racers",
     *     summary="Create a new racer",
     *     tags={"Racers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="racer_name", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *             @OA\Property(property="team_id", type="string"),
     *             @OA\Property(property="image", type="string"),
     *             @OA\Property(property="created_by", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'racer_name' => 'required|string|max:255',
                'user_id' => 'required|uuid',
                'team_id' => 'nullable|uuid',
                'image' => 'nullable|string',
                'created_by' => 'nullable|string',
            ]);

            $racer = $this->racerService->createRacer($data);

            return response()->json($racer, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/racers/{id}",
     *     summary="Get a racer by ID",
     *     tags={"Racers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Racer not found")
     * )
     */
    public function show(string $id)
    {
        $racer = $this->racerService->getRacerById($id);

        if (!$racer) {
            return response()->json(['message' => 'Racer not found'], 404);
        }

        return response()->json($racer);
    }

    /**
     * @OA\Put(
     *     path="/api/racers/{id}",
     *     summary="Update a racer",
     *     tags={"Racers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="racer_name", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *             @OA\Property(property="team_id", type="string"),
     *             @OA\Property(property="image", type="string"),
     *             @OA\Property(property="updated_by", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated"),
     *     @OA\Response(response=404, description="Racer not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'racer_name' => 'nullable|string|max:255',
                'user_id' => 'nullable|uuid',
                'team_id' => 'nullable|uuid',
                'image' => 'nullable|string',
                'updated_by' => 'nullable|string',
            ]);

            $racer = $this->racerService->updateRacer($id, $data);

            if (!$racer) {
                return response()->json(['message' => 'Racer not found'], 404);
            }

            return response()->json($racer);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/racers/team/{team_id}",
     *     summary="Get racers by team ID",
     *     tags={"Racers"},
     *     @OA\Parameter(
     *         name="team_id",
     *         in="path",
     *         required=true,
     *         description="Team ID to filter racers by",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of racers in the team",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Racer"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No racers found for the team"
     *     )
     * )
     */
    public function getByTeamId(string $team_id)
    {
        $racers = $this->racerService->getRacersByTeamId($team_id);

        if ($racers->isEmpty()) {
            return response()->json(['message' => 'No racers found for the given team'], 404);
        }

        return response()->json($racers);
    }

    /**
     * @OA\Delete(
     *     path="/api/racers/{id}",
     *     summary="Delete a racer",
     *     tags={"Racers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Deleted"),
     *     @OA\Response(response=404, description="Racer not found")
     * )
     */
    public function destroy(string $id)
    {
        $deleted = $this->racerService->deleteRacer($id);

        if (!$deleted) {
            return response()->json(['message' => 'Racer not found'], 404);
        }

        return response()->json(['message' => 'Racer deleted successfully']);
    }
}
