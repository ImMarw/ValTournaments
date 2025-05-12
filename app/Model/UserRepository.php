<?php declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

final class UserRepository
{
    public function __construct(private Explorer $db)
    {
    }

    /**
     * @return Selection<int, array{ id: int, username: string, role: string, ... }>
     */
    public function fetchAll(): Selection
    {
        // adjust table name / columns as needed
        return $this->db
            ->table('users')
            ->order('username ASC');
    }

    public function findById(int $id): ?\stdClass
    {
        return $this->db
            ->table('users')
            ->get($id);
    }

    public function delete(int $id): void
    {
        $this->db
            ->table('users')
            ->wherePrimary($id)
            ->delete();
    }

    public function setRole(int $id, string $role): void
    {
        $this->db
            ->table('users')
            ->wherePrimary($id)
            ->update(['role' => $role]);
    }
}