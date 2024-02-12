<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Domains\Task\TaskRepository;
use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;

class ScheduleService
{

    public function __construct(
        private ScheduleRepository $scheduleRepository,
        private TaskRepository     $taskRepository
    )
    {
    }

    /**
     * @throws InvalidCollectionDataProvidedException
     * @throws StorageDataMissingException
     */
    public function getScheduledTasks(int $scheduleId, array $taskIds): ScheduleEntity
    {
        $scheduleEntity = $this->scheduleRepository->getById($scheduleId);
        $tasks = $this->taskRepository->getByIds($taskIds);
        $items = $tasks->assignScheduleToEachTask($scheduleId);
        $scheduleEntity->setItems($items);
        return $scheduleEntity;
    }
}
