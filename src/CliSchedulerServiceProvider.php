<?php

namespace Koomai\CliScheduler;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Koomai\CliScheduler\Console\Commands\ScheduleAddCommand;
use Koomai\CliScheduler\Console\Commands\ScheduleDeleteCommand;
use Koomai\CliScheduler\Console\Commands\ScheduleDueCommand;
use Koomai\CliScheduler\Console\Commands\ScheduleListCommand;
use Koomai\CliScheduler\Console\Commands\ScheduleShowCommand;
use Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface;
use Koomai\CliScheduler\Enums\TaskType;
use Koomai\CliScheduler\Events\CompletedScheduledTask;
use Koomai\CliScheduler\Events\StartingScheduledTask;
use Koomai\CliScheduler\Repositories\Cache\CacheScheduledTaskRepository;
use Koomai\CliScheduler\Repositories\ScheduledTaskRepository;

class CliSchedulerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Config
        $this->publishes([
            __DIR__.'/../config/cli-scheduler.php.php' => config_path('cli-scheduler.php'),
        ]);

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cli-scheduler');

        // Scheduler Commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                ScheduleDueCommand::class,
                ScheduleAddCommand::class,
                ScheduleShowCommand::class,
                ScheduleDeleteCommand::class,
                ScheduleListCommand::class,
            ]);

            $repository = resolve(ScheduledTaskRepositoryInterface::class);
            if ($repository->hasTable()) {
                $this->scheduleTasks($repository->all());
            }
        }
    }

    public function register()
    {
        parent::register();

        $this->app->singleton(ScheduledTaskRepositoryInterface::class, function () {
            $scheduledTaskRepository = new ScheduledTaskRepository();

            return new CacheScheduledTaskRepository($scheduledTaskRepository, $this->app['cache.store']);
        });
    }

    private function scheduleTasks($tasks)
    {
        $this->app->resolving(Schedule::class, function ($schedule) use ($tasks) {
            $tasks->each(function ($task) use ($schedule) {
                switch ($task->type) {
                    case TaskType::JOB:
                        if ($task->queue) {
                            $scheduledEvent = $schedule->job(new $task->task(), $task->queue);
                        } else {
                            $scheduledEvent = $schedule->job(new $task->task());
                        }

                        break;
                    case TaskType::COMMAND:
                        $scheduledEvent = $schedule->command($task->task);

                        break;
                    default:
                        app('log')->alert("{$task->type} is not a valid scheduled task type");

                        return;
                }

                /* @var \Illuminate\Console\Scheduling\Event $scheduledEvent */
                $scheduledEvent
                    ->cron($task->cron)
                    ->timezone($task->timezone ?? config('app.timezone'))
                    ->before(function () use ($task) {
                        StartingScheduledTask::dispatch($task);
                    })
                    ->after(function () use ($task) {
                        CompletedScheduledTask::dispatch($task);
                    });

                if (! empty($task->environments)) {
                    $scheduledEvent->environments($task->environments);
                }

                if ($task->without_overlapping) {
                    $scheduledEvent->withoutOverlapping();
                }

                if ($task->on_one_server) {
                    $scheduledEvent->onOneServer();
                }

                if ($task->run_in_background) {
                    $scheduledEvent->runInBackground();
                }

                if ($task->in_maintenance_mode) {
                    $scheduledEvent->evenInMaintenanceMode();
                }

                if ($task->output_path) {
                    $scheduledEvent->sendOutputTo($task->output_path, $task->append_output);
                }

                if ($task->output_email) {
                    $scheduledEvent->emailOutputTo($task->output_email);
                }
            });
        });
    }
}
