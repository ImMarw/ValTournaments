<?php
namespace App\Presentation\Home;

use Nette;
use App\Model\UserManager;
use App\Model\MyAuthenticator;

final class SignPresenter extends Nette\Application\UI\Presenter
{
    private MyAuthenticator $authenticator;
    private UserManager $userManager;

    public function __construct(MyAuthenticator $authenticator, UserManager $userManager)
    {
        parent::__construct();
        $this->authenticator = $authenticator;
        $this->userManager = $userManager;
    }

    public function renderLogin(): void {}

    public function renderRegister(): void {}

    protected function createComponentLoginForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form;
        $form->addText('username', 'Username:')->setRequired();
        $form->addPassword('password', 'Password:')->setRequired();
        $form->addSubmit('send', 'Login');

        $form->onSuccess[] = function ($form, $values): void {
            try {
                $this->getUser()->login($values->username, $values->password);
                $this->redirect('Homepage:default');
            } catch (\Exception $e) {
                $form->addError('Invalid credentials.');
            }
        };

        return $form;
    }

    protected function createComponentRegisterForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form;
        $form->addText('username', 'Username:')->setRequired();
        $form->addText('email', 'Email:')->setRequired();
        $form->addPassword('password', 'Password:')->setRequired();
        $form->addSubmit('send', 'Register');

        $form->onSuccess[] = function ($form, $values): void {
            $this->userManager->add($values->username, $values->email, $values->password);
            $this->flashMessage('Registration successful, you can now login.', 'success');
            $this->redirect('Sign:login');
        };

        return $form;
    }
}
