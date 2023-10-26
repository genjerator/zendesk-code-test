<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Components\DatabaseInterface;

class ScheduleStorage
{

    public function __construct(private DatabaseInterface $db)
    {
    }

    public function getById(int $id): array
    {
        return $this->db->query('SELECT * FROM schedules WHERE id=:id', ["id" => $id]);
    }

    public function getByIds(array $ids): array
    {
        return $this->db->query('SELECT * FROM schedules WHERE id in (:ids)', $ids);
    }
}
