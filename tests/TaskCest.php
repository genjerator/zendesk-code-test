<?php
declare(strict_types=1);

namespace Tests;

use Codeception\Example;
use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Task\TaskCollection;
use Tymeshift\PhpTest\Domains\Task\TaskFactory;
use Tymeshift\PhpTest\Domains\Task\TaskRepository;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;

class TaskCest
{
    private ?TaskRepository $taskRepository;

    public function _before(): void
    {
        $this->httpClientMock = \Mockery::mock(HttpClientInterface::class);
        $storage = new TaskStorage($this->httpClientMock);
        $this->taskRepository = new TaskRepository($storage, new TaskFactory());
    }

    public function _after(): void
    {
        $this->taskRepository = null;
        \Mockery::close();
    }

    /**
     * @dataProvider tasksDataProvider
     * @throws InvalidCollectionDataProvidedException
     */
    public function testGetTasks(Example $example, \UnitTester $tester): void
    {
        $this->httpClientMock->shouldReceive('request')
            ->with('GET', sprintf('/%s/%d', TaskStorage::URL_GET_BY_SCHEDULE_ID, 1))
            ->andReturn(reset($example));
        $tasks = $this->taskRepository->getByScheduleId(1);
        $tester->assertInstanceOf(TaskCollection::class, $tasks);
    }

    public function testGetTasksFailed(\UnitTester $tester): void
    {
        $this->httpClientMock->shouldReceive('request')
            ->with('GET', sprintf('/%s/%d', TaskStorage::URL_GET_BY_SCHEDULE_ID, 4))
            ->andReturn([]);
        $tester->expectThrowable(\Exception::class, function () {
            $this->taskRepository->getByScheduleId(4);
        });
    }

    public function tasksDataProvider(): array
    {
        return [
            [
                ["id" => 123, "schedule_id" => 1, "start_time" => 0, "duration" => 3600],
                ["id" => 431, "schedule_id" => 1, "start_time" => 3600, "duration" => 650],
                ["id" => 332, "schedule_id" => 1, "start_time" => 5600, "duration" => 3600],
            ]
        ];
    }
}
