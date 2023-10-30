<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\RepositoryInterface;

class TaskRepository implements RepositoryInterface
{
    public function __construct(private TaskStorage $storage, private TaskFactory $factory)
    {
    }

    public function getById(int $id): TaskEntity
    {
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
        $data = $this->storage->getByIds($ids);
        return $this->factory->createCollection($data);
    }
}
