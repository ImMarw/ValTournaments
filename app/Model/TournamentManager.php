<?php
namespace App\Model;

use Nette\Database\Explorer;

final class TournamentManager
{
    private Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    // Fetch a tournament by its ID
    public function getById(int $id): ?\Nette\Database\Table\ActiveRow
    {
        return $this->database->table('tournaments')->get($id);
    }

    // Fetch all matches related to a tournament
    public function getMatches(int $tournamentId): \Nette\Database\Table\Selection
    {
        return $this->database->table('tournament_matches')->where('tournament_id', $tournamentId);
    }

    // Add a new tournament
    public function add(array $values): void
    {
        $this->database->table('tournaments')->insert([
            'name' => $values['name'],
            'image' => $values['image'],
            'region' => $values['region'],
            'start_time' => $values['start_time'],
            'status' => 'upcoming',
        ]);
    }

    // Get all tournaments (upcoming and finished)
    public function getAllTournaments(): array
    {
        return $this->database->table('tournaments')->fetchAll();
    }

    public function updateTournamentStatus(): void
    {
        $this->database->table('tournaments')
            ->where('start_time < ?', new \DateTime())
            ->where('status', 'upcoming')
            ->update(['status' => 'finished']);
    }

    public function getUpcoming(): \Nette\Database\Table\Selection
    {
        return $this->database->table('tournaments')->where('status', 'upcoming')->order('start_time');
    }

    public function getFinished(): \Nette\Database\Table\Selection
    {
        return $this->database->table('tournaments')->where('status', 'finished')->order('start_time DESC');
    }

}