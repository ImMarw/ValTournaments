<?php

namespace App\Presentation\Team;

use App\Model\TeamManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;

final class TeamPresenter extends Presenter
{
    public function __construct(
        private TeamManager $teamManager
    ) {}

    public function renderDefault(): void
    {
        // Zde nic nezměníme
    }

    protected function createComponentCreateTeamForm(): Form
    {
        $form = new Form;

        $form->addText('name', 'Název týmu:')
            ->setRequired();

        $form->addUpload('logo', 'Logo týmu (nahrát obrázek):')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Musí to být obrázkový soubor (JPEG, PNG nebo GIF)');

        $form->addSubmit('create', 'Vytvořit tým');

        $form->onSuccess[] = function (Form $form, \stdClass $values): void {
            if (!$this->getUser()->isLoggedIn()) {
                $this->error('Musíš být přihlášený.');
            }

            // Zpracování nahraného souboru (logu)
            $logo = $values->logo;
            $logoPath = 'images/teams/' . $logo->getName();

            // Uložení souboru do složky
            $logo->move($logoPath);

            // Vytvoření nového týmu
            $this->teamManager->createTeam($values, $this->getUser()->getId(), $logoPath);

            $this->flashMessage('Tým byl úspěšně vytvořen.');
            $this->redirect('Teams:default');
        };

        return $form;
    }
}