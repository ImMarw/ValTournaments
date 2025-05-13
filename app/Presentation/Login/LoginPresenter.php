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

        $renderer = $form->getRenderer();
        $renderer->wrappers['pair']['container'] = 'mb-3';

        // ─── BOOTSTRAP RENDERER CONFIG ────────────────────────────────────────────────
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container']      = null;
        $renderer->wrappers['pair']['container']          = 'mb-3';
        $renderer->wrappers['label']['container']         = '';
        $renderer->wrappers['control']['container']       = '';
        $renderer->wrappers['control']['description']     = 'form-text text-muted';
        $renderer->wrappers['control']['errorcontainer']  = 'invalid-feedback';
        // ─────────────────────────────────────────────────────────────────────────────

        // now build your form as usual:
        $form->addText('email', 'Email:')
            ->setHtmlAttribute('class','form-control mb-2')
            ->setRequired();
        $form->addPassword('password','Password:')
            ->setHtmlAttribute('class','form-control mb-2')
            ->setRequired();
        $form->addCheckbox('remember','Keep me logged in')
            ->setHtmlAttribute('class','form-check-input mb-4');
        $form->addSubmit('send','Log in')
            ->setHtmlAttribute('class','btn btn-primary w-100');

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