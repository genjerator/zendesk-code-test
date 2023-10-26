<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Components\HttpClientInterface;

class TaskStorage
{
    const URL_GET_BY_SCHEDULE_ID = 'get_by_schedule_id';
    const URL_GET_BY_IDS = 'get_by_ids';
    const URL_GET_BY_ID = 'get_by_id';

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function getByScheduleId(int $id): array
    {
        return $this->client->request('GET', sprintf('/%s/%d', self::URL_GET_BY_SCHEDULE_ID, $id));
    }

    public function getByIds(array $ids): array
    {
        // TODO: Implement getByIds() method.
        $csvIds = !empty($ids) ? implode(',', $ids) : '';
        return $this->client->request('GET', sprintf('/%s/%s', self::URL_GET_BY_IDS, $csvIds));
    }

    public function getById(int $id): array
    {
        return $this->client->request('GET', sprintf('/%s/%d',self::URL_GET_BY_ID, $id));
    }
}
