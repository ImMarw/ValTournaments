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

        $form->addText('email', 'Email:')
            ->setType('email')
            ->setRequired('Please enter your email.')
            ->addRule(Form::EMAIL, 'Enter a valid email.');

        // ← New username field
        $form->addText('username', 'Username:')
            ->setRequired('Please choose a username.')
            ->addRule(Form::MIN_LENGTH, 'Username must be at least %d characters.', 3)
            ->addRule(Form::PATTERN, 'Username may contain only letters, numbers and underscores.', '^[A-Za-z0-9_]+$');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter a password.')
            ->addRule(Form::MIN_LENGTH, 'Password must be at least %d characters', 6);

        $form->addPassword('passwordVerify', 'Confirm Password:')
            ->setRequired('Confirm your password.')
            ->addRule(Form::EQUAL, 'Passwords do not match.', $form['password']);

        $form->addSubmit('send', 'Sign up');
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