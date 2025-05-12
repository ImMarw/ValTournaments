<?php declare(strict_types=1);

namespace App\Presentation\Tournaments;

use Nette;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use App\Model\TournamentRepository;
use App\Model\TeamRepository;

final class TournamentsPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private TournamentRepository $tournaments,
        private TeamRepository       $teams,
    ) {
        parent::__construct();
    }

    /** ── List all tournaments ──────────────── */
    public function renderDefault(): void
    {
        $this->template->title       = 'All Tournaments';
        // show newest first
        $this->template->tournaments = $this->tournaments
            ->fetchAll()
            ->order('starts_at ASC');
        $this->template->isAdmin     = $this->getUser()->isInRole('admin');
    }

    /** ── Show single tournament detail ────── */
    public function renderDetail(int $id): void
    {
        $t = $this->tournaments->fetchById($id)
            ?? $this->error(404);

        // load both teams directly
        $team1 = $this->teams->fetchById((int) $t->team1_id);
        $team2 = $this->teams->fetchById((int) $t->team2_id);

        $this->template->title      = $t->name;
        $this->template->tournament = $t;
        $this->template->team1      = $team1;
        $this->template->team2      = $team2;
        $this->template->isAdmin    = $this->getUser()->isInRole('admin');
    }

    /** ── Display “create” form ───────────── */
    public function renderCreate(): void
    {
        $this->getUser()->isInRole('admin') || $this->error(403);
        $this->template->title = 'Create Tournament';
    }

    /** ── Display “edit” form ─────────────── */
    public function renderEdit(int $id): void
    {
        $this->getUser()->isInRole('admin') || $this->error(403);

        $t = $this->tournaments->fetchById($id)
            ?? $this->error(404);

        $this->template->title = 'Edit Tournament “' . $t->name . '”';

        // prefill the form
        $this['tournamentForm']->setDefaults([
            'id'       => $t->id,
            'name'     => $t->name,
            'start_at' => $t->starts_at->format('Y-m-d H:i'),
            'team1'    => $t->team1_id,
            'team2'    => $t->team2_id,
        ]);
    }

    /** ── Create the form component ───────── */
    protected function createComponentTournamentForm(): Form
    {
        $this->getUser()->isInRole('admin') || $this->error(403);

        $form = new Form;
        $form->addHidden('id');

        $form->addText('name', 'Name:')
            ->setRequired();

        $form->addText('start_at', 'Starts at (YYYY-MM-DD HH:MM):')
            ->setRequired();

        // logo is required only on create
        $form->addUpload('logo', 'Logo:')
            ->addConditionOn($form['id'], Form::BLANK)
            ->setRequired('Please upload a logo.')
            ->endCondition()
            ->addRule(Form::IMAGE, 'Must be JPEG, PNG or GIF');

        // team pickers
        $teams = [];
        foreach ($this->teams->fetchAll() as $team) {
            $teams[$team->id] = $team->name;
        }
        $form->addSelect('team1', 'Team 1:', $teams)
            ->setPrompt('— pick team —')
            ->setRequired();
        $form->addSelect('team2', 'Team 2:', $teams)
            ->setPrompt('— pick team —')
            ->setRequired();

        $form->addSubmit('send', 'Save');
        $form->onSuccess[] = [$this, 'tournamentFormSucceeded'];
        return $form;
    }

    /** ── Handle both create and update ───── */
    public function tournamentFormSucceeded(Form $form, \stdClass $v): void
    {
        // parse the datetime
        $dt = \DateTime::createFromFormat('Y-m-d H:i', $v->start_at)
            ?: $this->error('Bad date format');

        // if a new logo was uploaded, move it
        $logoPath = null;
        if ($v->logo instanceof FileUpload && $v->logo->isOk()) {
            $dir = dirname(__DIR__, 3) . '/www/img/tournaments';
            @mkdir($dir, 0755, true);
            $fn = 'tourn-' . time() . '.' . $v->logo->getImageFileExtension();
            $v->logo->move("$dir/$fn");
            $logoPath = '/img/tournaments/' . $fn;
        }

        if (!empty($v->id)) {
            // UPDATE
            $this->tournaments->updateTournament(
                (int)$v->id,
                $v->name,
                $dt,
                (int)$v->team1,
                (int)$v->team2,
                $logoPath
            );
            $this->flashMessage('Tournament updated', 'success');
            $this->redirect('detail', $v->id);

        } else {
            // CREATE
            $id = $this->tournaments->addTournament(
                $v->name,
                $logoPath,
                $dt,
                (int)$v->team1,
                (int)$v->team2
            );
            $this->flashMessage('Tournament created', 'success');
            $this->redirect('detail', $id);
        }
    }
}