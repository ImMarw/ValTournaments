<?php declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;

final class AdminLogRepository
{
    public function __construct(private Explorer $db) {}

    public function add(string $entity, int $entityId, string $action, int $adminId): void
    {
        $this->db->table('admin_logs')->insert([
            'entity'     => $entity,
            'entity_id'  => $entityId,
            'action'     => $action,
            'admin_id'   => $adminId,
        ]);
    }
}