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

    public function getUpcoming(): \Nette\Database\Table\Selection
    {
        return $this->database->table('tournaments')->where('status', 'upcoming')->order('start_time');
    }

    public function getFinished(): \Nette\Database\Table\Selection
    {
        return $this->database->table('tournaments')->where('status', 'finished')->order('start_time DESC');
    }
}
