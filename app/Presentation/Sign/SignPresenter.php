<?php

namespace App\Presentation\Sign;

use App\Model\UserManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Security\User;

final class SignPresenter extends Presenter
{
    private User $user;
    private UserManager $userManager;

    public function __construct(User $user, UserManager $userManager)
    {
        $this->user = $user;
        $this->userManager = $userManager;
    }

    protected function createComponentSignInForm(): Form
    {
        $form = new Form;

        $form->addText('username', 'Uživatelské jméno:')
            ->setRequired();

        $form->addPassword('password', 'Heslo:')
            ->setRequired();

        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }

    public function signInFormSucceeded(Form $form, \stdClass $values): void
    {
        try {
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Home:default');
        } catch (\Nette\Security\AuthenticationException $e) {
            $form->addError('Přihlášení se nezdařilo.');
        }
    }

    protected function createComponentSignUpForm(): Form
    {
        $form = new Form;

        $form->addText('username', 'Uživatelské jméno:')
            ->setRequired();

        $form->addEmail('email', 'Email:')
            ->setRequired();

        $form->addPassword('password', 'Heslo:')
            ->setRequired();

        $form->addPassword('password_confirm', 'Heslo znovu:')
            ->setRequired()
            ->addRule($form::EQUAL, 'Hesla se neshodují.', $form['password']);

        $form->addSubmit('send', 'Registrovat');

        $form->onSuccess[] = function (Form $form, \stdClass $values): void {
            try {
                $this->userManager->add(
                    $values->username,
                    $values->email,
                    $values->password
                );

                $this->flashMessage('Registrace proběhla úspěšně.', 'success');
                $this->redirect('Sign:login');
            } catch (\Exception $e) {
                $form->addError('Registrace se nezdařila: ' . $e->getMessage());
            }
        };

        return $form;
    }

    public function actionOut(): void
    {
        $this->user->logout();
        $this->flashMessage('Byl jsi odhlášen.');
        $this->redirect('Sign:login');
    }
}