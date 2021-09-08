<?php

namespace Koomai\CliScheduler\Console\Commands;

use Koomai\CliScheduler\Console\Commands\Traits\BuildsScheduledTasksTable;

class ScheduleShowCommand extends ScheduleCommand
{
    use BuildsScheduledTasksTable;

    protected $signature = 'schedule:show {ids : A comma-separated list of Ids to display, e.g. 1,7}';
    protected $description = 'Display scheduled task(s) by Id or Ids';

    public function handle()
    {
        $tasks = $this->repository->findByIds(explode(',', $this->argument('ids')));

        if ($tasks->isEmpty()) {
            $this->error('No scheduled tasks found');
            exit;
        }

        $this->generateTable($tasks);
    }
}
