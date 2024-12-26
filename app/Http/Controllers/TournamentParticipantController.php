<?php

namespace App\Http\Controllers;

use App\Services\TournamentParticipantService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TournamentParticipantController extends Controller
{
    protected TournamentParticipantService $participantService;

    public function __construct(TournamentParticipantService $participantService)
    {
        $this->participantService = $participantService;
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/{tournament_id}/participants",
     *     summary="Get all participants for a specific tournament",
     *     tags={"Tournament Participants"},
     *     @OA\Parameter(
     *         name="tournament_id",
     *         in="path",
     *         required=true,
     *         description="ID of the tournament",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of participants for the tournament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No participants found for the tournament"
     *     )
     * )
     */
    public function getParticipantsByTournamentId(string $tournament_id)
    {
        $participants = $this->participantService->getParticipantsByTournamentId($tournament_id);

        if ($participants->isEmpty()) {
            return response()->json(['message' => 'No participants found for the given tournament'], 404);
        }

        return response()->json($participants);
    }

    /**
     * @OA\Post(
     *     path="/api/participants",
     *     summary="Create a new tournament participant",
     *     tags={"Tournament Participants"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="tournament_id", type="string"),
     *             @OA\Property(property="racer_id", type="string"),
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
                'tournament_id' => 'required|uuid',
                'racer_id' => 'required|uuid',
                'created_by' => 'nullable|string',
            ]);

            $participant = $this->participantService->createParticipant($data);

            return response()->json($participant, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/participants/{id}",
     *     summary="Get a tournament participant by ID",
     *     tags={"Tournament Participants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Participant not found")
     * )
     */
    public function show(string $id)
    {
        $participant = $this->participantService->getParticipantById($id);

        if (!$participant) {
            return response()->json(['message' => 'Participant not found'], 404);
        }

        return response()->json($participant);
    }

    /**
     * @OA\Put(
     *     path="/api/participants/{id}",
     *     summary="Update a tournament participant",
     *     tags={"Tournament Participants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="tournament_id", type="string"),
     *             @OA\Property(property="racer_id", type="string"),
     *             @OA\Property(property="updated_by", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated"),
     *     @OA\Response(response=404, description="Participant not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'tournament_id' => 'nullable|uuid',
                'racer_id' => 'nullable|uuid',
                'updated_by' => 'nullable|string',
            ]);

            $participant = $this->participantService->updateParticipant($id, $data);

            if (!$participant) {
                return response()->json(['message' => 'Participant not found'], 404);
            }

            return response()->json($participant);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/participants/{id}",
     *     summary="Delete a tournament participant",
     *     tags={"Tournament Participants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Deleted"),
     *     @OA\Response(response=404, description="Participant not found")
     * )
     */
    public function destroy(string $id)
    {
        $deleted = $this->participantService->deleteParticipant($id);

        if (!$deleted) {
            return response()->json(['message' => 'Participant not found'], 404);
        }

        return response()->json(['message' => 'Participant deleted successfully']);
    }
}
