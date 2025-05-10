<?php

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

final class TeamManager
{
    public function __construct(
        private Explorer $database
    )
    {
    }

    /**
     * Vrátí všechny týmy
     */
    public function getAllTeams(): array
    {
        return $this->database->table('teams')->fetchAll();
    }

    /**
     * Vrátí konkrétní tým podle ID
     */
    public function getTeam(int $id): ?ActiveRow
    {
        return $this->database->table('teams')->get($id);
    }

    /**
     * Vrátí členy konkrétního týmu
     */
    public function getTeamMembers(int $teamId): array
    {
        return $this->database->table('team_members')
            ->where('team_id', $teamId)
            ->fetchAll();
    }

    /**
     * Vytvoří nový tým a přidá zakladatele jako člena
     */
    public function createTeam(\stdClass $values, int $userId, string $logoPath): void
    {
        $team = $this->database->table('teams')->insert([
            'name' => $values->name,
            'logo' => $logoPath,  // Uložíme cestu k logu
            'owner_id' => $userId,
        ]);

        $this->database->table('team_members')->insert([
            'team_id' => $team->id,
            'user_id' => $userId,
        ]);
    }

    /**
     * Smaže tým a jeho členy
     */
    public function deleteTeam(int $teamId): void
    {
        $this->database->table('team_members')->where('team_id', $teamId)->delete();
        $this->database->table('teams')->where('id', $teamId)->delete();
    }
}