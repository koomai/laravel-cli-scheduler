<?php

namespace Koomai\CliScheduler\Console\Commands;

use Koomai\CliScheduler\Console\Commands\Traits\BuildsScheduledTasksTable;

class ScheduleListCommand extends ScheduleCommand
{
    use BuildsScheduledTasksTable;

    protected $signature = 'schedule:list-all';
    protected $description = 'List all scheduled tasks';

    public function handle()
    {
        $tasks = $this->repository->all();

        if ($tasks->isEmpty()) {
            $this->error('No scheduled tasks found');
            exit;
        }

        $this->generateTable($tasks);
    }
}
