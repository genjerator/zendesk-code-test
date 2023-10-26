<?php

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\FactoryInterface;

class ScheduleRepository
{
    public function __construct(private ScheduleStorage $storage, private FactoryInterface $factory)
    {
    }

    /**
     * @throws StorageDataMissingException
     */
    public function getById(int $id):EntityInterface
    {
        $data = $this->storage->getById($id);
        if(empty($data)){
            throw new StorageDataMissingException(sprintf('Schedule id %d does not exists.',$id));
        }
        return $this->factory->createEntity($data);
    }
}
