<?php
// app/Presentation/Register/RegisterPresenter.php
namespace App\Presentation\Register;

use Nette;
use Nette\Application\UI\Form;
use Nette\Database\Explorer;

class RegisterPresenter extends Nette\Application\UI\Presenter
{
    private Explorer $db;

    public function __construct(Explorer $db)
    {
        parent::__construct();
        $this->db = $db;
    }

    protected function createComponentRegisterForm(): Form
    {
        $form = new Form;

        $renderer = $form->getRenderer();
        $renderer->wrappers['pair']['container'] = 'mb-5';

        // ─── 2) Bootstrap‐style renderer configuration ─────────────────────
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container']     = null;
        $renderer->wrappers['pair']['container']         = 'mb-3';
        $renderer->wrappers['label']['container']        = '';
        $renderer->wrappers['control']['container']      = '';
        $renderer->wrappers['control']['description']    = 'form-text text-muted';
        $renderer->wrappers['control']['errorcontainer'] = 'invalid-feedback';
        // ──────────────────────────────────────────────────────────────────

        // ─── 3) Build the fields ───────────────────────────────────────────
        $form->addText('email', 'Email:')
            ->setHtmlAttribute('class','form-control mb-2')
            ->setRequired('Please enter your email.')
            ->addRule(Form::EMAIL, 'Enter a valid email.');

        $form->addText('username', 'Username:')
            ->setHtmlAttribute('class','form-control mb-2')
            ->setRequired('Please choose a username.')
            ->addRule(Form::MIN_LENGTH, 'At least %d characters.', 3)
            ->addRule(Form::PATTERN, 'Only letters, numbers, and underscores.', '^[A-Za-z0-9_]+$');

        $form->addPassword('password', 'Password:')
            ->setHtmlAttribute('class','form-control mb-2')
            ->setRequired('Please enter a password.')
            ->addRule(Form::MIN_LENGTH, 'At least %d characters.', 6);

        $form->addPassword('passwordVerify', 'Confirm Password:')
            ->setHtmlAttribute('class','form-control mb-4')
            ->setRequired('Please confirm your password.')
            ->addRule(Form::EQUAL, 'Passwords do not match.', $form['password']);

        // ─── 4) Big blue submit button ────────────────────────────────────
        $form->addSubmit('send', 'Sign up')
            ->setHtmlAttribute('class', 'btn btn-success btn-lg w-100');

        $form->onSuccess[] = [$this, 'registerFormSucceeded'];
        return $form;
    }


    public function registerFormSucceeded(Form $form, \stdClass $values): void
    {
        // check email unique
        if ($this->db->table('users')->where('email', $values->email)->count()) {
            $form->addError('Email is already registered.');
            return;
        }
        // check username unique
        if ($this->db->table('users')->where('username', $values->username)->count()) {
            $form->addError('Username is already taken.');
            return;
        }

        $hash = password_hash($values->password, PASSWORD_DEFAULT);

        $this->db->table('users')->insert([
            'email'    => $values->email,
            'username' => $values->username,   // ← store it
            'password' => $hash,
            'role'     => 'user',
        ]);

        $this->flashMessage('Registration successful! You can now log in.', 'success');
        $this->redirect('Login:default');
    }

    public function renderDefault(): void
    {
        $this->template->title = 'Register';
    }
}