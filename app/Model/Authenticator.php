<?php
namespace App\Model;

use Nette;
use Nette\Security\Authenticator;
use Nette\Security\Identity;
use Nette\Security\Passwords;

final class MyAuthenticator implements Authenticator
{
    use Nette\SmartObject;

    private Nette\Database\Explorer $database;
    private Passwords $passwords;

    public function __construct(Nette\Database\Explorer $database, Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    public function authenticate(string $username, string $password): Identity
    {
        $row = $this->database->table('users')
            ->where('username', $username)
            ->fetch();

        if (!$row || !$this->passwords->verify($password, $row->password)) {
            throw new Nette\Security\AuthenticationException('Incorrect username or password.');
        }

        return new Identity($row->id, [$row->role], $row->toArray());
    }
}
