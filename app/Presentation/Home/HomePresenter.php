<?php
namespace App\Presentation\Home;

use Nette;
use App\Model\TournamentManager;

final class HomePresenter extends Nette\Application\UI\Presenter
{
    private TournamentManager $tournamentManager;

    public function __construct(TournamentManager $tournamentManager)
    {
        parent::__construct();
        $this->tournamentManager = $tournamentManager;
    }

    public function renderDefault(): void
    {
        $this->template->upcoming = $this->tournamentManager->getUpcoming()->limit(3);
    }
}
