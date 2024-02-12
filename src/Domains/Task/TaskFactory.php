<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\FactoryInterface;

class TaskFactory implements FactoryInterface
{

    public function createEntity(array $data): TaskEntity
    {
        $entity = new TaskEntity();
        if (isset($data['id']) && is_int($data['id'])) {
            $entity->setId($data['id']);
        }

        if (isset($data['name']) && is_string($data['name'])) {
            $entity->setName($data['name']);
        }

        if (isset($data['start_time']) && is_string($data['start_time'])) {
            $entity->setStartTime(intval($data['start_time']));
        }

        if (isset($data['duration']) && is_string($data['duration'])) {
            $entity->setStartTime(intval($data['duration']));
        }

        if (isset($data['schedule_id']) && is_string($data['schedule_id'])) {
            $entity->setStartTime(intval($data['schedule_id']));
        }

        if (isset($data['description']) && is_string($data['description'])) {
            $entity->setDescription($data['description']);
        }

        return $entity;
    }

    /**
     * @throws InvalidCollectionDataProvidedException
     */
    public function createCollection(array $data):CollectionInterface
    {
        return (new TaskCollection())->createFromArray($data, $this);
    }
}
