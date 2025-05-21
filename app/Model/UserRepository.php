<?php declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\Database\Table\ActiveRow;

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

    public function findByEmail(string $email): ?ActiveRow
    {
        return $this->db
            ->table('users')
            ->where('email', $email)
            ->fetch();            // returns ActiveRow|null
    }


    public function findOneByMember(int $userId): ?ActiveRow
    {
        // start from teams table
        $teams = $this->db
            ->table('teams')
            // bring in the pivot so we can filter on its user_id
            ->innerJoin('team_members', 'team_members.team_id = teams.id');

        return $teams
            // match either owner_id or the joined team_members
            ->where('(teams.owner_id = ? OR team_members.user_id = ?)', $userId, $userId)
            ->limit(1)
            ->fetch();
    }
}