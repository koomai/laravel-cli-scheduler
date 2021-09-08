<?php

namespace Koomai\CliScheduler\Tests\Console\Commands;

use Koomai\CliScheduler\Enums\TaskType;
use Koomai\CliScheduler\Tests\TestCase;

class ScheduleAddCommandWithPromptAndDefaultConfigurationTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set('scheduler.environments', ['production']);
    }

    /**
     * @test
     */
    public function shouldNotAskForEnvironmentsIfAlreadyDefinedInConfig()
    {
        $this->artisan('schedule:add')
            ->expectsQuestion(trans('cli-scheduler::questions.type'), TaskType::COMMAND)
            ->expectsQuestion(trans('cli-scheduler::questions.task.artisan'), 'schedule:show')
            ->expectsQuestion(trans('cli-scheduler::questions.description'), 'Some description')
            ->expectsQuestion(trans('cli-scheduler::questions.cron'), '* * * * *')
            ->expectsQuestion(trans('cli-scheduler::questions.timezone'), 'Australia/Sydney')
            ->expectsQuestion(trans('cli-scheduler::questions.environments'), 'prod,staging')
            ->expectsQuestion(trans('cli-scheduler::questions.overlapping'), 'Yes')
            ->expectsQuestion(trans('cli-scheduler::questions.one_server'), 'Yes')
            ->expectsOutput(trans('cli-scheduler::messages.cache_driver_alert'))
            ->expectsQuestion(trans('cli-scheduler::questions.maintenance'), 'Yes')
            ->expectsQuestion(trans('cli-scheduler::questions.background'), 'Yes')
            ->expectsQuestion(trans('cli-scheduler::questions.confirm_output_path'), true)
            ->expectsQuestion(trans('cli-scheduler::questions.output_path'), '/var/logs/output.log')
            ->expectsQuestion(trans('cli-scheduler::questions.append_output'), 'Yes')
            ->expectsQuestion(trans('cli-scheduler::questions.output_email'), 'test@test.com')
            ->assertExitCode(0);

        $expectedData = [
                'type' => TaskType::COMMAND,
                'task' => 'schedule:show',
                'description' => 'Some description',
                'cron' => '* * * * *',
                'timezone' => 'Australia/Sydney',
                'environments' => json_encode(['prod','staging']),
                'queue' => null,
                'without_overlapping' => 1,
                'on_one_server' => 1,
                'run_in_background' => 1,
                'in_maintenance_mode' => 1,
                'output_path' => '/var/logs/output.log',
                'append_output' => 1,
                'output_email' => 'test@test.com',
            ];

        $this->assertDatabaseHas(config('scheduler.table'), $expectedData);
    }
}
