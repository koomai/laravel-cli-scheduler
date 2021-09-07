<?php

namespace Koomai\CliScheduler\Console\Commands;

use Koomai\CliScheduler\Console\Commands\Traits\BuildsScheduledTasksTable;

class ScheduleListCommand extends ScheduleCommand
{
    use BuildsScheduledTasksTable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all scheduled tasks';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
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
