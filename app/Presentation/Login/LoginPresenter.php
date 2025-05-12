<?php
// app/Presentation/Login/LoginPresenter.php
namespace App\Presentation\Login;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

class LoginPresenter extends Nette\Application\UI\Presenter
{
    protected function createComponentLoginForm(): Form
    {
        $form = new Form;
        $form->addText('email', 'Email:')
            ->setType('email')
            ->setRequired('Please enter your email.');
        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');
        $form->addSubmit('send', 'Log in');
        $form->onSuccess[] = [$this, 'loginFormSucceeded'];
        return $form;
    }

    public function loginFormSucceeded(Form $form, \stdClass $values): void
    {
        try {
            $this->getUser()->login($values->email, $values->password);
            $this->flashMessage('Welcome back!', 'success');
            $this->redirect('Home:default');
        } catch (AuthenticationException $e) {
            $form->addError('Invalid email or password.');
        }
    }

    public function renderDefault(): void
    {
        $this->template->title = 'Log in';
    }
}