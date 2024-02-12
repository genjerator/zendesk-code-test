<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Domains\Schedule\ScheduleItemInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

class TaskEntity implements EntityInterface, ScheduleItemInterface
{

    private int $id;
    private string $name;
    private string $description;
    public int $scheduleId;
    private int $startTime;
    private int $duration;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TaskEntity
     */
    public function setId(int $id): TaskEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TaskEntity
     */
    public function setName(string $name): TaskEntity
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return TaskEntity
     */
    public function setDescription(string $description): TaskEntity
    {
        $this->description = $description;
        return $this;
    }
    public function setStartTime(int $startTime): TaskEntity
    {
        $this->startTime = $startTime;
        return $this;
    }
    public function setScheduleId(int $scheduleId): TaskEntity
    {
        $this->scheduleId = $scheduleId;
        return $this;
    }
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    public function getStartTime(): int
    {
       return $this->startTime;
    }

    public function getEndTime(): int
    {
        return $this->startTime+$this->duration;
    }

    public function getType(): string
    {
        return "task";
    }
}
