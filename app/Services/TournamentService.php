<?php

namespace App\Services;

use App\Models\Tournament;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TournamentService
{
    /**
     * Get all tournaments.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTournaments()
    {
        return Tournament::all();
    }

    /**
     * Get a specific tournament by ID.
     *
     * @param string $id
     * @return Tournament
     * @throws ModelNotFoundException
     */
    public function getTournamentById(string $id): Tournament
    {
        return Tournament::findOrFail($id);
    }

    /**
     * Create a new tournament.
     *
     * @param array $data
     * @return Tournament
     */
    public function createTournament(array $data): Tournament
    {
        return Tournament::create($data);
    }

    /**
     * Update an existing tournament.
     *
     * @param string $id
     * @param array $data
     * @return Tournament
     * @throws ModelNotFoundException
     */
    public function updateTournament(string $id, array $data): Tournament
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->update($data);

        return $tournament;
    }

    /**
     * Delete a tournament by ID.
     *
     * @param string $id
     * @return void
     * @throws ModelNotFoundException
     */
    public function deleteTournament(string $id): void
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->delete();
    }
}
