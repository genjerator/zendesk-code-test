<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Interfaces\EntityInterface;

class TaskEntity implements EntityInterface
{

    private int $id;
    private string $name;
    private string $description;


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

}
