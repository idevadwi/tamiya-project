<?php

namespace App\Http\Controllers;

use App\Services\TournamentService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Info(
 *     title="Tournament API",
 *     version="1.0.0",
 *     description="API documentation for managing tournaments"
 * )
 * @OA\Tag(
 *     name="Tournaments",
 *     description="Operations about tournaments"
 * )
 * @OA\Schema(
 *     schema="TournamentRequest",
 *     type="object",
 *     required={"tournament_name", "vendor_name", "description", "image", "current_stage", "current_session", "track_number", "champ_number", "bto_number", "status"},
 *     @OA\Property(property="tournament_name", type="string", description="The name of the tournament"),
 *     @OA\Property(property="vendor_name", type="string", description="The name of the vendor"),
 *     @OA\Property(property="description", type="string", description="Description of the tournament"),
 *     @OA\Property(property="image", type="string", description="Image URL of the tournament"),
 *     @OA\Property(property="current_stage", type="integer", description="The current stage of the tournament"),
 *     @OA\Property(property="current_session", type="integer", description="The current session of the tournament"),
 *     @OA\Property(property="track_number", type="integer", description="The track number"),
 *     @OA\Property(property="champ_number", type="integer", description="The champion number"),
 *     @OA\Property(property="bto_number", type="integer", description="The back-to-office number"),
 *     @OA\Property(property="status", type="string", description="The status of the tournament"),
 *     @OA\Property(property="created_by", type="string", description="ID of the user who created the tournament", nullable=true),
 *     @OA\Property(property="updated_by", type="string", description="ID of the user who last updated the tournament", nullable=true)
 * )
 * @OA\Schema(
 *     schema="Tournament",
 *     type="object",
 *     @OA\Property(property="id", type="string", description="The UUID of the tournament"),
 *     @OA\Property(property="tournament_name", type="string", description="The name of the tournament"),
 *     @OA\Property(property="vendor_name", type="string", description="The name of the vendor"),
 *     @OA\Property(property="description", type="string", description="Description of the tournament"),
 *     @OA\Property(property="image", type="string", description="Image URL of the tournament"),
 *     @OA\Property(property="current_stage", type="integer", description="The current stage of the tournament"),
 *     @OA\Property(property="current_session", type="integer", description="The current session of the tournament"),
 *     @OA\Property(property="track_number", type="integer", description="The track number"),
 *     @OA\Property(property="champ_number", type="integer", description="The champion number"),
 *     @OA\Property(property="bto_number", type="integer", description="The back-to-office number"),
 *     @OA\Property(property="status", type="string", description="The status of the tournament"),
 *     @OA\Property(property="created_by", type="string", description="ID of the user who created the tournament", nullable=true),
 *     @OA\Property(property="updated_by", type="string", description="ID of the user who last updated the tournament", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
 * )
 */
class TournamentController extends Controller
{
    protected $tournamentService;

    public function __construct(TournamentService $tournamentService)
    {
        $this->tournamentService = $tournamentService;
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments",
     *     summary="Get all tournaments",
     *     tags={"Tournaments"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of tournaments",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Tournament"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->tournamentService->getAllTournaments());
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/{id}",
     *     summary="Get tournament by ID",
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tournament ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tournament details",
     *         @OA\JsonContent(ref="#/components/schemas/Tournament")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tournament not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            return response()->json($this->tournamentService->getTournamentById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tournament not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/tournaments",
     *     summary="Create a new tournament",
     *     tags={"Tournaments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TournamentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tournament created",
     *         @OA\JsonContent(ref="#/components/schemas/Tournament")
     *     ),
     *     @OA\Parameter(
     *          name="X-CSRF-TOKEN",
     *          in="header",
     *          required=true,
     *          @OA\Schema(type="string")
     *      )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tournament_name' => 'required|string',
            'vendor_name' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'current_stage' => 'nullable|integer',
            'current_session' => 'nullable|integer',
            'track_number' => 'required|integer',
            'champ_number' => 'required|integer',
            'bto_number' => 'required|integer',
            'status' => 'required|string',
            'created_by' => 'nullable|string',
            'updated_by' => 'nullable|string',
        ]);

        return response()->json($this->tournamentService->createTournament($data), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/tournaments/{id}",
     *     summary="Update a tournament",
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tournament ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TournamentRequest")
     *     ),
     *     @OA\Parameter(
     *          name="X-CSRF-TOKEN",
     *          in="header",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Tournament updated",
     *         @OA\JsonContent(ref="#/components/schemas/Tournament")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tournament not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tournament_name' => 'sometimes|required|string',
            'vendor_name' => 'sometimes|nullable|string',
            'description' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|string',
            'current_stage' => 'sometimes|nullable|integer',
            'current_session' => 'sometimes|nullable|integer',
            'track_number' => 'sometimes|required|integer',
            'champ_number' => 'sometimes|required|integer',
            'bto_number' => 'sometimes|required|integer',
            'status' => 'sometimes|required|string',
            'created_by' => 'nullable|string',
            'updated_by' => 'nullable|string',
        ]);

        try {
            return response()->json($this->tournamentService->updateTournament($id, $data));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tournament not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/tournaments/{id}",
     *     summary="Delete a tournament",
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tournament ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tournament deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tournament not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->tournamentService->deleteTournament($id);
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tournament not found'], 404);
        }
    }
}
