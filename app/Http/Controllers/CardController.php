<?php

namespace App\Http\Controllers;

use App\Services\CardService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CardController extends Controller
{
    protected CardService $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * @OA\Get(
     *     path="/api/cards",
     *     summary="Get all cards",
     *     tags={"Cards"},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        return response()->json($this->cardService->getAllCards());
    }

    /**
     * @OA\Post(
     *     path="/api/cards",
     *     summary="Create a new card",
     *     tags={"Cards"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="card_code", type="string"),
     *             @OA\Property(property="racer_id", type="string"),
     *             @OA\Property(property="coupon", type="integer"),
     *             @OA\Property(property="status", type="string"),
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
                'card_code' => 'required|string|unique:cards,card_code',
                'racer_id' => 'nullable|uuid',
                'coupon' => 'nullable|integer',
                'status' => 'nullable|string',
                'created_by' => 'nullable|string',
            ]);

            $card = $this->cardService->createCard($data);

            return response()->json($card, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/cards/{id}",
     *     summary="Get a card by ID",
     *     tags={"Cards"},
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
        $card = $this->cardService->getCardById($id);

        if (!$card) {
            return response()->json(['message' => 'Card not found'], 404);
        }

        return response()->json($card);
    }

    /**
     * @OA\Get(
     *     path="/api/cards/code/{card_code}",
     *     summary="Get a card by card code",
     *     tags={"Cards"},
     *     @OA\Parameter(
     *         name="card_code",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function getByCardCode(string $card_code)
    {
        $card = $this->cardService->getCardByCardCode($card_code);

        if (!$card) {
            return response()->json(['message' => 'Card not found'], 404);
        }

        return response()->json($card);
    }

    /**
     * @OA\Get(
     *     path="/api/cards/racer/{racer_id}",
     *     summary="Get cards by racer ID",
     *     tags={"Cards"},
     *     @OA\Parameter(
     *         name="racer_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function getByRacerId(string $racer_id)
    {
        $cards = $this->cardService->getCardsByRacerId($racer_id);

        return response()->json($cards);
    }


    /**
     * @OA\Put(
     *     path="/api/cards/{id}",
     *     summary="Update a card",
     *     tags={"Cards"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="card_code", type="string"),
     *             @OA\Property(property="racer_id", type="string"),
     *             @OA\Property(property="coupon", type="integer"),
     *             @OA\Property(property="status", type="string"),
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
                'card_code' => 'nullable|string',
                'racer_id' => 'nullable|uuid',
                'coupon' => 'nullable|integer',
                'status' => 'nullable|string',
                'updated_by' => 'nullable|string',
            ]);

            $card = $this->cardService->updateCard($id, $data);

            if (!$card) {
                return response()->json(['message' => 'Card not found'], 404);
            }

            return response()->json($card);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/cards/{id}",
     *     summary="Delete a card",
     *     tags={"Cards"},
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
        $deleted = $this->cardService->deleteCard($id);

        if (!$deleted) {
            return response()->json(['message' => 'Card not found'], 404);
        }

        return response()->json(['message' => 'Card deleted successfully']);
    }
}
