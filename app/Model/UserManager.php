<?php
namespace App\Model;

use Nette;
use Nette\Security\Passwords;

final class UserManager
{
    use Nette\SmartObject;

    private Nette\Database\Explorer $database;
    private Passwords $passwords;

    public function __construct(Nette\Database\Explorer $database, Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    public function add(string $username, string $email, string $password): void
    {
        $this->database->table('users')->insert([
            'username' => $username,
            'email' => $email,
            'password' => $this->passwords->hash($password),
        ]);
    }
}
