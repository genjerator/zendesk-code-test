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
