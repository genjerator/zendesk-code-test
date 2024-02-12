<?php

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Base\BaseCollection;
use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;

class TaskCollection extends BaseCollection
{
    /**
     * @throws InvalidCollectionDataProvidedException
     */
    public function assignScheduleToEachTask(int $scheduleId): array
    {
        return array_map(function($item) use ($scheduleId){
            return $item->setScheduleId($scheduleId);
        },$this->items);
    }

}
