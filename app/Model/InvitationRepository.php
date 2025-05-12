<?php
namespace App\Model;

use Nette\Database\Explorer;
use Nette\Utils\Random;

class InvitationRepository
{
    private Explorer $db;
    public function __construct(Explorer $db) { $this->db = $db; }

    public function invite(int $teamId, string $email, int $invitedBy): string
    {
        $token = Random::generate(32, '0-9a-zA-Z');
        $this->db->table('team_invitations')->insert([
            'team_id'    => $teamId,
            'email'      => $email,
            'token'      => $token,
            'invited_by' => $invitedBy,
        ]);
        return $token;
    }

    public function getByToken(string $token)
    {
        return $this->db->table('team_invitations')->where('token', $token)->fetch();
    }

    public function respond(string $token, string $status): void
    {
        $this->db->table('team_invitations')
            ->where('token', $token)
            ->update(['status' => $status]);
    }

    public function pendingFor(string $email)
    {
        return $this->db->table('team_invitations')
            ->where('email', $email)
            ->where('status', 'pending');
    }
}