<?php

namespace Koomai\CliScheduler\Console\Commands;

use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface;
use Koomai\CliScheduler\ScheduledTask;

class ScheduleDueCommand extends ScheduleCommand
{
    protected $signature = 'schedule:due';
    protected $description = 'List all scheduled tasks that are due';
    private array $headers = [
        'Id',
        'Type',
        'Task',
        'Description',
        'Cron',
        'Next due',
        'Environments',
    ];
    private Schedule $schedule;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @param \Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface $repository
     */
    public function __construct(Schedule $schedule, ScheduledTaskRepositoryInterface $repository)
    {
        parent::__construct($repository);

        $this->schedule = $schedule;
    }

    public function handle()
    {
        if (empty($this->schedule->events())) {
            $this->warn('No scheduled tasks found');

            return;
        }

        $eventsDue = collect($this->schedule->events())->map(function (Event $event) {
            $scheduledTask = $this->mapEventToScheduledTask($event);

            return [
                'id' => $scheduledTask ? $scheduledTask->id : 'N/A',
                'type' => $scheduledTask ? $scheduledTask->type : 'Console Kernel',
                'task' => $scheduledTask ? $scheduledTask->task : $this->parseTaskFromEvent($event),
                'description' => $scheduledTask ? $scheduledTask->description : $event->description,
                'cron' => $event->expression,
                'due' => $event->nextRunDate()->format(config('scheduler.date_format')),
                'environments' => implode(', ', $event->environments),
            ];
        })->toArray();

        $this->table($this->headers, $eventsDue, 'box');
    }

    private function mapEventToScheduledTask(Event $event): ?ScheduledTask
    {
        return $this->repository->findByTaskAndCronSchedule($this->parseTaskFromEvent($event), $event->expression);
    }

    private function parseTaskFromEvent(Event $event): string
    {
        if ($event instanceof CallbackEvent) {
            return $event->getSummaryForDisplay();
        }

        return Str::after($event->command, "'artisan' ");
    }
}
