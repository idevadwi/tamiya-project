<?php

namespace App\Http\Controllers;

use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * @OA\Get(
     *     path="/api/teams",
     *     summary="Get all teams",
     *     tags={"Teams"},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        return response()->json($this->teamService->getAllTeams());
    }

    /**
     * @OA\Post(
     *     path="/api/teams",
     *     summary="Create a new team",
     *     tags={"Teams"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="team_name", type="string"),
     *             @OA\Property(property="description", type="string"),
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
                'team_name' => 'required|string|max:255|unique:teams,team_name',
                'description' => 'nullable|string',
                'image' => 'nullable|string',
                'created_by' => 'nullable|string',
            ]);

            $team = $this->teamService->createTeam($data);

            return response()->json($team, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/teams/{id}",
     *     summary="Get a team by ID",
     *     tags={"Teams"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function show(string $id)
    {
        $team = $this->teamService->getTeamById($id);

        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        return response()->json($team);
    }

    /**
     * @OA\Put(
     *     path="/api/teams/{id}",
     *     summary="Update a team",
     *     tags={"Teams"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="team_name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="image", type="string"),
     *             @OA\Property(property="updated_by", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'team_name' => 'nullable|string|max:255|unique:teams,team_name',
                'description' => 'nullable|string',
                'image' => 'nullable|string',
                'updated_by' => 'nullable|string',
            ]);

            $team = $this->teamService->updateTeam($id, $data);

            if (!$team) {
                return response()->json(['message' => 'Team not found'], 404);
            }

            return response()->json($team);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/teams/{id}",
     *     summary="Delete a team",
     *     tags={"Teams"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function destroy(string $id)
    {
        $deleted = $this->teamService->deleteTeam($id);

        if (!$deleted) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        return response()->json(['message' => 'Team deleted successfully']);
    }
}
