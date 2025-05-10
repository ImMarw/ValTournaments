<?php
namespace App\Presentation\Tournament;

use App\Model\TournamentManager;
use Nette;

final class TournamentPresenter extends Nette\Application\UI\Presenter
{
    private TournamentManager $tournamentManager;

    public function __construct(TournamentManager $tournamentManager)
    {
        parent::__construct();
        $this->tournamentManager = $tournamentManager;
    }

    public function renderDetail(int $id): void
    {
        $tournament = $this->tournamentManager->getById($id);

        if (!$tournament) {
            $this->error('Turnaj nebyl nalezen');
        }

        $this->template->tournament = $tournament;
        $this->template->matches = $this->tournamentManager->getMatches($id);
    }

    public function renderCreate(): void
    {
        if (!$this->getUser()->isLoggedIn() || !$this->getUser()->isInRole('admin')) {
            $this->error('Přístup odepřen.', 403);
        }
    }

    protected function createComponentCreateTournamentForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form;

        $form->addText('name', 'Název turnaje:')
            ->setRequired();

        $form->addText('image', 'Obrázek (soubor v /images):')
            ->setRequired();

        $form->addText('region', 'Region:')
            ->setRequired();

        $form->addText('start_time', 'Začátek (YYYY-MM-DD HH:MM):')
            ->setRequired()
            ->addRule($form::PATTERN, 'Datum musí být ve formátu YYYY-MM-DD HH:MM', '\d{4}-\d{2}-\d{2} \d{2}:\d{2}');

        $form->addSubmit('send', 'Vytvořit turnaj');

        $form->onSuccess[] = function ($form, $values): void {
            $this->tournamentManager->add((array) $values);
            $this->flashMessage('Turnaj úspěšně vytvořen.', 'success');
            $this->redirect('Tournaments:default');
        };

        return $form;
    }

    public function renderDefault(): void
    {
        $this->template->tournaments = $this->tournamentManager->getAllTournaments();
    }


}
