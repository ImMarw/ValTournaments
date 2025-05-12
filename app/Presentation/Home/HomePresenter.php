<?php
namespace App\Presentation\Home;

use Nette\Application\UI\Presenter;

class HomePresenter extends Presenter
{
    public function renderDefault(): void
    {
        // any data you want to pass to the template:
        $this->template->title = 'Welcome to Valorant Tournaments';
    }
}
