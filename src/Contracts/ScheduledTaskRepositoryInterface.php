<?php

namespace Koomai\CliScheduler\Contracts;

use Koomai\CliScheduler\ScheduledTask;
use Illuminate\Database\Eloquent\Collection;

interface ScheduledTaskRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?ScheduledTask;

    public function findByIds(array $ids): ?Collection;

    public function create(array $data): ScheduledTask;

    public function delete(int $id): int;

    public function hasTable(): bool;

    public function findByTaskAndCronSchedule(string $task, string $cron): ?ScheduledTask;
}
