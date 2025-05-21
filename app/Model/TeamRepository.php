<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Database\ResultSet;

final class TeamRepository
{
    public function __construct(private Explorer $db)
    {
    }
    public function fetchAll(): Selection
    {
        return $this->db->table('teams')
            ->order('id ASC');
    }

    /**
     * Get a single team row
     */
    public function fetchById(int $id): ?ActiveRow
    {
        return $this->db->table('teams')->get($id);
    }

    /**
     * Create a new team
     */
    public function addTeam(string $name, string $logoPath, int $ownerId): int
    {
        $row = $this->db->table('teams')->insert([
            'name'     => $name,
            'logo'     => $logoPath,
            'owner_id' => $ownerId,
        ]);
        return (int) $row->id;
    }

    /**
     * Update an existing team
     */
    public function updateTeam(int $teamId, array $data): void
    {
        $this->db->table('teams')
            ->where('id', $teamId)
            ->update($data);
    }

    /**
     * Add/remove/count team members
     */
    public function addMember(int $teamId, int $userId): void
    {
        $this->db->table('team_members')->insert([
            'team_id' => $teamId,
            'user_id' => $userId,
        ]);
    }

    public function removeMember(int $teamId, int $userId): void
    {
        $this->db->table('team_members')
            ->where('team_id', $teamId)
            ->where('user_id', $userId)
            ->delete();
    }

    public function countMembers(int $teamId): int
    {
        return $this->db->table('team_members')
            ->where('team_id', $teamId)
            ->count();
    }

    public function delete(int $teamId): void
    {
        $this->db
            ->table('teams')
            ->where('id', $teamId)
            ->delete();
    }

    // in app/Model/TeamRepository.php

    public function getAllWithOwners(): Selection
    {
        return $this->db->table('teams')
            ->select('teams.*, users.username AS owner_name')
            ->join('users', 'users.id = teams.owner_id')
            ->order('teams.id ASC');
    }

    public function userHasTeam(int $userId): bool
    {
        return (bool) $this->db
            ->table('team_members')
            ->where('user_id', $userId)
            ->count();
    }
    public function findOneByMember(int $userId): ?ActiveRow
    {
        // 1) First, are they the owner?
        $team = $this->db
            ->table('teams')
            ->where('owner_id', $userId)
            ->fetch();

        if ($team) {
            return $team;
        }

        // 2) Otherwise, are they in team_members?
        $pivot = $this->db
            ->table('team_members')
            ->where('user_id', $userId)
            ->fetch();

        if (! $pivot) {
            return null;
        }

        // finally, load that team by its ID
        return $this->db
            ->table('teams')
            ->get($pivot->team_id);
    }
}