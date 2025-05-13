<?php declare(strict_types=1);

namespace App\Presentation\Invite;

use Nette;
use Nette\Application\UI\Form;
use App\Model\InvitationRepository;
use App\Model\TeamRepository;

final class InvitePresenter extends Nette\Application\UI\Presenter
{
    private InvitationRepository $invites;
    private TeamRepository $teams;

    public function __construct(
        InvitationRepository $invites,
        TeamRepository $teams
    ) {
        parent::__construct();
        $this->invites = $invites;
        $this->teams   = $teams;
    }

    // ── 5) /invitations (Notifications nav) ────────────────────────────────
    public function renderList(): void
    {
        $this->template->title   = 'My Invitations';
        $pending = $this->invites
            ->pendingFor($this->getUser()->identity->email)
            ->fetchAll();

        $this->template->pending      = $pending;
        $this->template->pendingCount = count($pending);
    }

    // ── 6) /invitation/<token>?accept or ?decline ───────────────────────────
    public function actionRespond(string $token, ?string $do): void
    {
        $inv = $this->invites->getByToken($token);
        if (! $inv || $inv->email !== $this->getUser()->identity->email) {
            $this->error(404);
        }

        if ($do === 'accept') {
            $this->invites->respond($token, 'accepted');
            // add to team
            $this->teams->addMember(
                $inv->team_id,
                (int) $this->getUser()->getId()
            );
            $this->flashMessage('Joined the team!', 'success');
        } else {
            $this->invites->respond($token, 'declined');
            $this->flashMessage('Invite declined.', 'info');
        }

        $this->redirect('Invite:list');
    }

    // ── 7) Invite form on Team detail (only owner) ──────────────────────────
    protected function createComponentInviteForm(): Form
    {
        $form = new Form;
        $form->addText('email', 'User email:')
            ->setType('email')
            ->setRequired();
        $form->addHidden('teamId');
        $form->addSubmit('send', 'Send Invite');
        $form->onSuccess[] = function (Form $form, \stdClass $v): void {
            $this->invites->invite(
                $v->teamId,
                $v->email,
                (int) $this->getUser()->getId()
            );
            $this->flashMessage('Invitation sent!', 'success');
            $this->redirect('this', $v->teamId);
        };
        return $form;
    }
}