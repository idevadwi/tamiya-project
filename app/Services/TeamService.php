<?php

namespace App\Services;

use App\Models\Team;

class TeamService
{
    /**
     * Create a new team.
     *
     * @param array $data
     * @return Team
     */
    public function createTeam(array $data): Team
    {
        return Team::create($data);
    }

    /**
     * Get all teams.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTeams()
    {
        return Team::all();
    }

    /**
     * Get a team by ID.
     *
     * @param string $id
     * @return Team|null
     */
    public function getTeamById(string $id): ?Team
    {
        return Team::find($id);
    }

    /**
     * Update a team by ID.
     *
     * @param string $id
     * @param array $data
     * @return Team|null
     */
    public function updateTeam(string $id, array $data): ?Team
    {
        $team = Team::find($id);
        if ($team) {
            $team->update($data);
        }
        return $team;
    }

    /**
     * Delete a team by ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteTeam(string $id): bool
    {
        $team = Team::find($id);
        return $team ? $team->delete() : false;
    }
}
