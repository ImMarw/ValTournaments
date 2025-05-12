<?php
// app/Model/UserAuthenticator.php
namespace App\Model;

use Nette;
use Nette\Database\Explorer;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\Identity;
use Nette\Security\AuthenticationException;

final class UserAuthenticator implements Authenticator
{
    private Explorer $db;

    public function __construct(Explorer $db)
    {
        $this->db = $db;
    }

    /**
     * @param  string  $username  // in our case this is the email
     * @param  string  $password
     * @return IIdentity
     * @throws AuthenticationException
     */
    public function authenticate(string $username, string $password): IIdentity
    {
        // here $username is actually the email
        $row = $this->db
            ->table('users')
            ->where('email', $username)
            ->fetch();

        if (! $row) {
            throw new AuthenticationException('User not found', self::IDENTITY_NOT_FOUND);
        }

        if (! password_verify($password, $row->password)) {
            throw new AuthenticationException('Invalid password', self::INVALID_CREDENTIAL);
        }

        // collect roles, payload
        $roles = [$row->role];
        $data = [
            'email'    => $row->email,
            'username' => $row->username,
        ];

        // return an Identity (which implements IIdentity)
        return new Identity($row->id, $roles, $data);
    }
}