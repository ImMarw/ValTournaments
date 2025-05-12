<?php
namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

class TournamentRepository
{
    public function __construct(private Explorer $db) {}

    /**
     * Fetch all tournaments, sorted by start date ascending.
     */
    public function fetchAll(): Selection
    {
        return $this->db
            ->table('tournaments')
            ->order('starts_at ASC');  // ← drop any created_at here
    }

    public function fetchById(int $id)
    {
        return $this->db
            ->table('tournaments')
            ->get($id);
    }

    public function addTournament(
        string $name,
        ?string $logoPath,
        \DateTimeInterface $startsAt,
        int $team1Id,
        int $team2Id
    ): int {
        $row = $this->db->table('tournaments')->insert([
            'name'      => $name,
            'logo'      => $logoPath,
            'starts_at' => $startsAt,
            'team1_id'  => $team1Id,
            'team2_id'  => $team2Id,
        ]);
        return $row->id;
    }

    public function updateTournament(
        int $id,
        string $name,
        \DateTimeInterface $startsAt,
        int $team1Id,
        int $team2Id,
        ?string $logoPath
    ): void {
        $data = [
            'name'      => $name,
            'starts_at' => $startsAt,
            'team1_id'  => $team1Id,
            'team2_id'  => $team2Id,
        ];
        if ($logoPath !== null) {
            $data['logo'] = $logoPath;
        }
        $this->db->table('tournaments')
            ->where('id', $id)
            ->update($data);
    }
}