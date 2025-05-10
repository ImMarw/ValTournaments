<?php
namespace App\Presentation\Home;

use App\Model\TournamentManager;
use Nette;

final class TournamentsPresenter extends Nette\Application\UI\Presenter
{
    private TournamentManager $tournamentManager;

    public function __construct(TournamentManager $tournamentManager)
    {
        parent::__construct();
        $this->tournamentManager = $tournamentManager;
    }

    public function renderDefault(): void
    {
        // Získání všech turnajů
        $this->template->tournaments = $this->tournamentManager->getAllTournaments();
    }
}