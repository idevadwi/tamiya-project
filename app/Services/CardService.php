<?php

namespace App\Services;

use App\Models\Card;

class CardService
{
    /**
     * Create a new card.
     *
     * @param array $data
     * @return Card
     */
    public function createCard(array $data): Card
    {
        return Card::create($data);
    }

    /**
     * Get all cards.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCards()
    {
        return Card::all();
    }

    /**
     * Get a card by ID.
     *
     * @param string $id
     * @return Card|null
     */
    public function getCardById(string $id): ?Card
    {
        return Card::find($id);
    }

    /**
     * Get a card by card code.
     *
     * @param string $cardCode
     * @return Card|null
     */
    public function getCardByCardCode(string $cardCode): ?Card
    {
        return Card::where('card_code', $cardCode)->first();
    }

    /**
     * Get cards by racer ID.
     *
     * @param string $racerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCardsByRacerId(string $racerId)
    {
        return Card::where('racer_id', $racerId)->get();
    }

    /**
     * Update a card by ID.
     *
     * @param string $id
     * @param array $data
     * @return Card|null
     */
    public function updateCard(string $id, array $data): ?Card
    {
        $card = Card::find($id);
        if ($card) {
            $card->update($data);
        }
        return $card;
    }

    /**
     * Delete a card by ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteCard(string $id): bool
    {
        $card = Card::find($id);
        return $card ? $card->delete() : false;
    }
}
