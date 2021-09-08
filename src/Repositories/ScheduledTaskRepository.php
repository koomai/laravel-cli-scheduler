<?php

namespace Koomai\CliScheduler\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface;
use Koomai\CliScheduler\ScheduledTask;

class ScheduledTaskRepository implements ScheduledTaskRepositoryInterface
{
    public function all(): Collection
    {
        return ScheduledTask::all();
    }

    public function find(int $id): ?ScheduledTask
    {
        return ScheduledTask::find($id);
    }

    public function findByIds(array $ids): ?Collection
    {
        return ScheduledTask::whereIn('id', $ids)->get();
    }

    public function findByTaskAndCronSchedule(string $task, string $cron): ?ScheduledTask
    {
        return ScheduledTask::where('task', $task)->where('cron', $cron)->first();
    }

    public function create(array $data): ScheduledTask
    {
        return ScheduledTask::create($data);
    }

    public function delete(int $id): int
    {
        return ScheduledTask::destroy($id);
    }

    public function hasTable(): bool
    {
        return Schema::hasTable(config('scheduler.table'));
    }
}
