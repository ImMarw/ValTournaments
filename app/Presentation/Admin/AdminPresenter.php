<?php declare(strict_types=1);

namespace App\Presentation\Admin;

use Nette;
use App\Model\UserRepository;
use App\Model\TeamRepository;
use App\Model\TournamentRepository;
use App\Model\AdminLogRepository;

final class AdminPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private UserRepository        $users,
        private TeamRepository        $teams,
        private TournamentRepository  $tournaments,
        private AdminLogRepository    $logs,
    ) {
        parent::__construct();
    }

    protected function startup(): void
    {
        parent::startup();
        if (! $this->getUser()->isInRole('admin')) {
            $this->error(403);
        }
    }

    public function renderDefault(): void
    {
        // just a dashboard linking to each section
        $this->template->title = 'Admin Dashboard';
    }

    // ── Users ────────────────────────────────────────
    public function renderUsers(): void
    {
        $this->template->title = 'Manage Users';
        $this->template->users = $this->users->fetchAll();
    }

    public function handleDeleteUser(int $id): void
    {
        $this->users->delete($id);
        $this->logs->add('user', $id, 'delete', (int)$this->getUser()->getId());
        $this->flashMessage("User #$id deleted", 'success');
        $this->redirect('this');
    }

    // ── Teams ───────────────────────────────────────
    public function renderTeams(): void
    {
        $this->getUser()->isInRole('admin') || $this->error(403);
        $this->template->teams = $this->teams->fetchAll();
        $this->template->title = 'Manage Teams';
    }

    public function handleDeleteTeam(int $id): void
    {
        $this->teams->delete($id);                              // ← now exists
        $this->logs->add('team', $id, 'delete', $this->getUser()->getId());
        $this->flashMessage("Team #{$id} deleted", 'success');
        $this->redirect('this');  // or →redirect('teams') to be explicit
    }

    // ── Tournaments ────────────────────────────────
    public function renderTournaments(): void
    {
        $this->template->title       = 'Manage Tournaments';
        $this->template->tournaments = $this->tournaments->fetchAll();
    }

    public function handleDeleteTournament(int $id): void
    {
        $this->tournaments->delete($id);
        $this->logs->add('tournament', $id, 'delete', (int)$this->getUser()->getId());
        $this->flashMessage("Tournament #$id deleted", 'success');
        $this->redirect('this');
    }
}