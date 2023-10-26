<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\RepositoryInterface;

class TaskRepository implements RepositoryInterface
{
    /**
     * @var TaskFactory
     */
    private $factory;

    /**
     * @var TaskStorage
     */
    private $storage;

    public function __construct(TaskStorage $storage, TaskFactory $factory)
    {
        $this->factory = $factory;
        $this->storage = $storage;
    }

    public function getById(int $id): EntityInterface
    {
        // TODO: Implement getById() method.
        $data = $this->storage->getById($id);
        return $this->factory->createEntity($data);
    }

    /**
     * @throws InvalidCollectionDataProvidedException
     * @throws \Exception
     */
    public function getByScheduleId(int $scheduleId):TaskCollection
    {

        $data = $this->storage->getByScheduleId($scheduleId);
        if(empty($data)){
            throw new StorageDataMissingException("test");
        }
        return $this->factory->createCollection($data);
    }

    /**
     * @throws InvalidCollectionDataProvidedException
     */
    public function getByIds(array $ids): TaskCollection
    {
        // TODO: Implement getByIds() method.
        return $this->factory->createCollection([]);
    }
}
