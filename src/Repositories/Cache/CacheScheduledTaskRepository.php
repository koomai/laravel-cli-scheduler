<?php

namespace Koomai\CliScheduler\Repositories\Cache;

use Illuminate\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;
use Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface;
use Koomai\CliScheduler\Repositories\ScheduledTaskRepository;
use Koomai\CliScheduler\ScheduledTask;

class CacheScheduledTaskRepository implements ScheduledTaskRepositoryInterface
{
    private ScheduledTaskRepository$repository;
    private Cache $cache;

    public function __construct(ScheduledTaskRepository $scheduledTaskRepository, Cache $cache)
    {
        $this->repository = $scheduledTaskRepository;
        $this->cache = $cache;
    }

    public function all(): Collection
    {
        return $this->cache->rememberForever('scheduled_tasks.all', function () {
            return $this->repository->all();
        });
    }

    public function find(int $id): ?ScheduledTask
    {
        return $this->cache->rememberForever("scheduled_tasks.id.{$id}", function () use ($id) {
            return $this->repository->find($id);
        });
    }

    public function findByIds(array $ids): ?Collection
    {
        return $this->repository->findByIds($ids);
    }

    public function create(array $data): ScheduledTask
    {
        $scheduledTask = $this->repository->create($data);
        $this->invalidateCache();

        return $scheduledTask;
    }

    public function delete(int $id): int
    {
        $count = $this->repository->delete($id);
        $this->invalidateCache($id);

        return $count;
    }

    private function invalidateCache(?int $id = null): void
    {
        $this->cache->forget('scheduled_tasks.all');

        if ($id) {
            $this->cache->forget("scheduled_tasks.id.{$id}");
        }
    }

    /**
     * Cache only if the table exists
     * This prevents a false value from being cached if the migration hasn't run
     */
    public function hasTable(): bool
    {
        $key = 'scheduled_tasks.has_table';

        if (! $this->cache->get($key)) {
            $this->cache->forget($key);

            return $this->cache->rememberForever($key, function () {
                return $this->repository->hasTable();
            });
        }

        return $this->cache->get($key);
    }

    public function findByTaskAndCronSchedule(string $task, string $cron): ?ScheduledTask
    {
        return $this->repository->findByTaskAndCronSchedule($task, $cron);
    }
}
