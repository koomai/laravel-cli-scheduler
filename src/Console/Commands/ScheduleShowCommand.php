<?php

namespace Koomai\CliScheduler\Console\Commands;

use Koomai\CliScheduler\Console\Commands\Traits\BuildsScheduledTasksTable;

class ScheduleShowCommand extends ScheduleCommand
{
    use BuildsScheduledTasksTable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:show {ids : A comma-separated list of Ids to display, e.g. 1,7}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display scheduled task(s) by Id or Ids';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
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
