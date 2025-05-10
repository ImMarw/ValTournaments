<?php

declare(strict_types=1);

namespace App\Presentation\Teams;

use App\Model\TeamManager;
use Nette\Application\UI\Presenter;

final class TeamsPresenter extends Presenter
{
    public function __construct(
        private TeamManager $teamManager,
    ) {}

    public function renderDefault(): void
    {
        $this->template->teams = $this->teamManager->getAllTeams();
    }

    public function renderDetail(int $id): void
    {
        $team = $this->teamManager->getTeam($id);
        if (!$team) {
            $this->error('Tým nebyl nalezen.');
        }
        $this->template->team = $team;
        $this->template->members = $this->teamManager->getTeamMembers($id);
    }
}