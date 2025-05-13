<?php declare(strict_types=1);

namespace App\Presentation\Teams;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Http\FileUpload;
use App\Model\TeamRepository;
use App\Model\InvitationRepository;

final class TeamsPresenter extends Presenter
{
    private TeamRepository $teams;
    private InvitationRepository $invites;

    public function __construct(TeamRepository $teams, InvitationRepository $invites)
    {
        parent::__construct();
        $this->teams   = $teams;
        $this->invites = $invites;
    }

    // ─────────── List all teams ─────────────────────────────────────────────
    public function renderDefault(): void
    {
        $this->template->title     = 'All Teams';
        $this->template->teams     = $this->teams->fetchAll();
        $this->template->canCreate = $this->getUser()->isLoggedIn();
    }

    // ─────────── Show create form ───────────────────────────────────────────
    public function renderCreate(): void
    {
        $this->template->title = 'Create Team';
    }

    protected function createComponentCreateTeamForm(): Form
    {

        $form = new Form;
        $form->addText('name', 'Team name:')
            ->setRequired('Please enter a team name.');

        $form->addUpload('logo', 'Logo:')
            ->setRequired('Please upload a logo.')
            ->addRule(
                Form::MIME_TYPE,
                'Logo must be JPEG, PNG or GIF',
                ['image/jpeg', 'image/png', 'image/gif']
            );

        $form->addSubmit('send', 'Create Team');
        $form->onSuccess[] = [$this, 'createTeamFormSucceeded'];
        return $form;
    }

    public function createTeamFormSucceeded(Form $form, \stdClass $values): void
    {
        /** @var FileUpload $logo */
        $logo = $values->logo;

        $projectRoot = dirname(__DIR__, 3);                  // project root
        $uploadDir   = $projectRoot . '/www/img/teams';

        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = 'team-' . time() . '.' . $logo->getImageFileExtension();
        $logo->move("$uploadDir/$filename");

        $teamId = $this->teams->addTeam(
            $values->name,
            '/img/teams/' . $filename,
            (int) $this->getUser()->getId()
        );
        $this->teams->addMember($teamId, (int) $this->getUser()->getId());

        $this->flashMessage('Team created successfully!', 'success');
        $this->redirect('Teams:detail', $teamId);
    }

    // ─────────── Detail page ────────────────────────────────────────────────
    public function renderDetail(int $id): void
    {
        $team = $this->teams->fetchById($id)
            ?? $this->error(404);

        // 1) pivot rows
        $links = $team->related('team_members');

        // 2) map to User ActiveRows
        $members = [];
        foreach ($links as $link) {
            $user = $link->ref('user');  // uses `user_id` → `users.id`
            if ($user) {
                $members[] = $user;
            }
        }

        // 3) leader is first member
        $leader = $members[0] ?? null;

        // 4) owner / invitation rights
        $isOwner   = (int)$this->getUser()->getId() === $team->owner_id;
        $canInvite = $isOwner;
        $canRemove = $isOwner;

        // 5) expose to template
        $this->template->team      = $team;
        $this->template->members   = $members;
        $this->template->leader    = $leader;
        $this->template->isOwner   = $isOwner;
        $this->template->canInvite = $canInvite;
        $this->template->canRemove = $canRemove;
        $this->template->title     = $team->name;
        $this->template->isLoggedIn = $this->getUser()->isLoggedIn();
    }

    // ─────────── “My Team” redirect ────────────────────────────────────────
    public function renderMyTeam(): void
    {
        if (! $this->getUser()->isLoggedIn()) {
            $this->error(403);
        }

        $this->template->title = 'My Team';
        $team = $this->teams->fetchAll()
            ->where('owner_id', (int)$this->getUser()->getId())
            ->fetch();

        if (! $team) {
            $this->template->noTeam = true;
        } else {
            $this->redirect('Teams:detail', $team->id);
        }
    }

    // ─────────── Invite form component ─────────────────────────────────────
    protected function createComponentInviteForm(): Form
    {
        $form = new Form;
        $form->addText('email', 'Invite by email:')
            ->setType('email')
            ->setRequired();
        // populate hidden teamId so insert isn’t zero
        $form->addHidden('teamId')
            ->setDefaultValue($this->getParameter('id'));
        $form->addSubmit('send', 'Send Invite');
        $form->onSuccess[] = function (Form $form, \stdClass $v): void {
            $this->invites->invite(
                (int)$v->teamId,
                $v->email,
                (int)$this->getUser()->getId()
            );
            $this->flashMessage('Invitation sent!', 'success');
            $this->redirect('this');
        };
        return $form;
    }

    // ─────────── Signal for removing a member ──────────────────────────────
    public function handleRemoveMember(int $teamId, int $userId): void
    {
        $this->teams->removeMember($teamId, $userId);
        $this->flashMessage('Member removed.', 'info');
        $this->redirect('this');
    }

    public function handleLeaveTeam(int $teamId): void
    {
        $userId = (int) $this->getUser()->getId();
        $this->teams->removeMember($teamId, $userId);
        $this->flashMessage('You have left the team.', 'info');
        // if they were the owner, you might redirect somewhere else
        $this->redirect('Teams:default');
    }

    /** Only the owner may access */
    public function actionEdit(int $id): void
    {
        $team = $this->teams->fetchById($id);
        if (! $team) {
            $this->error('Team not found', 404);
        }
        $this->template->team = $team;
    }

    public function renderEdit(int $id): void
    {
        // just set page title
        $this->template->title = 'Edit “' . $this->template->team->name . '”';
    }

    protected function createComponentEditTeamForm(): Form
    {
        /** @var \Nette\Database\Table\ActiveRow $team */
        $team = $this->template->team;
        if (! $team) {
            $this->error('Team not found', 404);
        }

        $form = new Form;
        $form->addText('name', 'Team name:')
            ->setDefaultValue($team->name)
            ->setRequired('Please enter a team name.');

        // logo upload is optional on edit
        $form->addUpload('logo', 'Logo:')
            ->addRule(
                Form::MIME_TYPE,
                'Logo must be JPEG, PNG or GIF',
                ['image/jpeg','image/png','image/gif']
            );

        $form->addHidden('id', (string)$team->id);

        $form->addSubmit('send', 'Save changes');
        $form->onSuccess[] = [$this, 'editTeamFormSucceeded'];
        return $form;
    }

    public function editTeamFormSucceeded(Form $form, \stdClass $values): void
    {
        $team = $this->teams->fetchById((int)$values->id);
        if (! $team) {
            $this->error('Team not found', 404);
        }

        $update = ['name' => $values->name];

        // handle optional new logo
        if ($values->logo instanceof FileUpload && $values->logo->isOk()) {
            $projectRoot = dirname(__DIR__, 3);
            $uploadDir   = $projectRoot . '/www/img/teams';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = 'team-' . time() . '.' . $values->logo->getImageFileExtension();
            $values->logo->move("$uploadDir/$filename");
            $update['logo'] = '/img/teams/' . $filename;
        }

        $this->teams->updateTeam($team->id, $update);
        $this->flashMessage('Team updated successfully.', 'success');
        $this->redirect('Teams:detail', $team->id);
    }
}