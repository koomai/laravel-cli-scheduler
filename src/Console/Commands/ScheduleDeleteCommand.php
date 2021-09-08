<?php

namespace Koomai\CliScheduler\Console\Commands;

class ScheduleDeleteCommand extends ScheduleCommand
{
    protected $signature = 'schedule:delete {id : Scheduled task Id}';
    protected $description = 'Delete a scheduled task by Id';

    public function handle()
    {
        $id = $this->argument('id');
        $task = $this->repository->delete((int) $id);

        if ($task) {
            $this->info("Scheduled task [{$id}] has been deleted");

            return;
        }

        $this->warn("Scheduled task [{$id}] does not exist");
    }
}
