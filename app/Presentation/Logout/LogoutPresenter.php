<?php
// app/Presentation/Logout/LogoutPresenter.php
namespace App\Presentation\Logout;

use Nette\Application\UI\Presenter;

class LogoutPresenter extends Presenter
{
    public function actionDefault(): void
    {
        $this->getUser()->logout(true);
        $this->flashMessage('You have been logged out.', 'info');
        $this->redirect('Home:default');
    }
}