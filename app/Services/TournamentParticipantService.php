<?php

namespace App\Services;

use App\Models\TournamentParticipant;

class TournamentParticipantService
{
    /**
     * Get a tournament participant by ID.
     *
     * @param string $id
     * @return TournamentParticipant|null
     */
    public function getParticipantById(string $id): ?TournamentParticipant
    {
        return TournamentParticipant::find($id);
    }

    /**
     * Create a new tournament participant.
     *
     * @param array $data
     * @return TournamentParticipant
     */
    public function createParticipant(array $data): TournamentParticipant
    {
        return TournamentParticipant::create($data);
    }

    /**
     * Update a tournament participant by ID.
     *
     * @param string $id
     * @param array $data
     * @return TournamentParticipant|null
     */
    public function updateParticipant(string $id, array $data): ?TournamentParticipant
    {
        $participant = TournamentParticipant::find($id);
        if ($participant) {
            $participant->update($data);
        }
        return $participant;
    }

    /**
     * Delete a tournament participant by ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteParticipant(string $id): bool
    {
        $participant = TournamentParticipant::find($id);
        return $participant ? $participant->delete() : false;
    }

    /**
     * Get participants by a specific tournament ID.
     *
     * @param string $tournamentId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParticipantsByTournamentId(string $tournamentId)
    {
        return TournamentParticipant::where('tournament_id', $tournamentId)->get();
    }
}

