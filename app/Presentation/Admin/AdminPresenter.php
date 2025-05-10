<?php
namespace App\Presentation\Admin;

use Nette;
use App\Model\TournamentManager;
use App\Model\TeamManager;
use Nette\Database\Explorer;

final class AdminPresenter extends Nette\Application\UI\Presenter
{
    private TournamentManager $tournamentManager;
    private TeamManager $teamManager;
    private Explorer $database;

    public function __construct(
        TournamentManager $tournamentManager,
        TeamManager $teamManager,
        Explorer $database
    ) {
        parent::__construct();
        $this->tournamentManager = $tournamentManager;
        $this->teamManager = $teamManager;
        $this->database = $database;
    }

    public function renderDefault(): void
    {
        if (!$this->getUser()->isInRole('admin')) {
            $this->error('Přístup odepřen.');
        }

        $this->template->tournaments = $this->tournamentManager->getUpcoming();
        $this->template->teams = $this->teamManager->getAll();
        $this->template->users = $this->database->table('users')->order('created_at DESC');
    }

    public function handleDeleteTeam(int $id): void
    {
        if (!$this->getUser()->isInRole('admin')) {
            $this->error('Nepovolený přístup.');
        }

        $this->database->table('teams')->where('id', $id)->delete();
        $this->flashMessage('Tým byl smazán.');
        $this->redirect('this');
    }

    public function handleDeleteUser(int $id): void
    {
        if (!$this->getUser()->isInRole('admin')) {
            $this->error('Nepovolený přístup.');
        }

        $this->database->table('users')->where('id', $id)->delete();
        $this->flashMessage('Uživatel byl smazán.');
        $this->redirect('this');
    }

    public function handleFinishTournament(int $id): void
    {
        if (!$this->getUser()->isInRole('admin')) {
            $this->error('Nepovolený přístup.');
        }

        $this->database->table('tournaments')->where('id', $id)->update([
            'status' => 'finished'
        ]);

        $this->flashMessage('Turnaj označen jako dokončený.');
        $this->redirect('this');
    }

}