<?php
declare(strict_types=1);

use Codeception\Example;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleRepository;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleFactory;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleService;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleStorage;
use Tymeshift\PhpTest\Domains\Task\TaskFactory;
use Tymeshift\PhpTest\Domains\Task\TaskRepository;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;

class ScheduleServiceCest
{

    /**
     * @var MockInterface|ScheduleStorage
     */
    private $scheduleStorageMock;

    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;
    /**
     * @var ScheduleService
     */
    private $scheduleService;

    private ?TaskRepository $taskRepository;

    public function _before()
    {
        $this->scheduleStorageMock = \Mockery::mock(ScheduleStorage::class);
        $this->scheduleRepository = new ScheduleRepository($this->scheduleStorageMock, new ScheduleFactory());

        $this->httpClientMock = \Mockery::mock(HttpClientInterface::class);
        $storage = new TaskStorage($this->httpClientMock);
        $this->taskRepository = new TaskRepository($storage, new TaskFactory());
        $this->scheduleService = new ScheduleService($this->scheduleRepository, $this->taskRepository);
    }

    public function _after()
    {
        $this->scheduleRepository = null;
        $this->scheduleStorageMock = null;
        $this->taskRepository = null;
        \Mockery::close();
    }

    /**
     * @dataProvider scheduleProvider
     * @throws \Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException
     * @throws StorageDataMissingException
     */
    public function testGetByIdSuccess(Example $example, \UnitTester $tester)
    {
        ['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name, 'tasks' => $tasks] = $example;
        $data = ['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name, 'tasks' => $tasks];
        //var_dump($data);
        $this->scheduleStorageMock
            ->shouldReceive('getById')
            ->with($id)
            ->andReturn(['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name]);

        $schedule = $this->scheduleRepository->getById($id);
        $tester->assertEquals($id, $schedule->getId());

        $this->httpClientMock->shouldReceive('request')
            ->with('GET', sprintf('/%s/%s', TaskStorage::URL_GET_BY_IDS, "123,431,332"))
            ->andReturn($example['tasks']);
        $scheduleEntity = $this->scheduleService->getScheduledTasks(1,[123,431,332]);
        $tester->assertEquals($id, $schedule->getId());
        $items = $scheduleEntity->getItems();
        $tester->assertEquals(3, count($items));
        foreach ($items as $index => $item) {
            $tester->assertEquals(1, $item->getScheduleId());
        }

    }

    /**
     * @return array[]
     */
    protected function scheduleProvider(): array
    {
        return [
            ['id' => 1, 'start_time' => 1631232000, 'end_time' => 1631232000 + 86400, 'name' => 'Test', 'tasks' =>
                [
                    ["id" => 123, "start_time" => 0, "duration" => 3600],
                    ["id" => 431, "start_time" => 3600, "duration" => 650],
                    ["id" => 332, "start_time" => 5600, "duration" => 3600],
                ]
            ]];
    }
}