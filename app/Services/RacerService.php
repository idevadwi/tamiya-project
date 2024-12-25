<?php

namespace App\Services;

use App\Models\Racer;

class RacerService
{
    /**
     * Get all racers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRacers()
    {
        return Racer::all();
    }

    /**
     * Get a racer by ID.
     *
     * @param string $id
     * @return Racer|null
     */
    public function getRacerById(string $id): ?Racer
    {
        return Racer::find($id);
    }

    /**
     * Create a new racer.
     *
     * @param array $data
     * @return Racer
     */
    public function createRacer(array $data): Racer
    {
        return Racer::create($data);
    }

    /**
     * Update a racer by ID.
     *
     * @param string $id
     * @param array $data
     * @return Racer|null
     */
    public function updateRacer(string $id, array $data): ?Racer
    {
        $racer = Racer::find($id);
        if ($racer) {
            $racer->update($data);
        }
        return $racer;
    }

    /**
     * Delete a racer by ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteRacer(string $id): bool
    {
        $racer = Racer::find($id);
        return $racer ? $racer->delete() : false;
    }

    /**
     * Get racers by a specific team ID.
     *
     * @param string $teamId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRacersByTeamId(string $teamId)
    {
        return Racer::where('team_id', $teamId)->get();
    }

    /**
     * Get a racer by user ID.
     *
     * @param string $userId
     * @return Racer|null
     */
    public function getRacerByUserId(string $userId): ?Racer
    {
        return Racer::where('user_id', $userId)->first();
    }
}
