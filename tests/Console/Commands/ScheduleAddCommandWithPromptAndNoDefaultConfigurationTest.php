<?php

namespace Koomai\CliScheduler\Tests\Console\Commands;

use Koomai\CliScheduler\Enums\TaskType;
use Koomai\CliScheduler\Tests\TestCase;

class ScheduleAddCommandWithPromptAndNoDefaultConfigurationTest extends TestCase
{
    protected function mapToChoice(int $choice): string
    {
        return $choice === 1 ? 'Yes' : 'No';
    }

    /**
     * @test
     */
    public function should_display_error_and_exit_if_task_type_is_invalid()
    {
        $this->artisan('schedule:add')
            ->expectsQuestion(trans('cli-scheduler::questions.type'), 'Invalid')
            ->expectsOutput(trans('cli-scheduler::messages.invalid_task_type', ['type' => 'Invalid']))
            ->assertExitCode(1);
    }

    /**
     * This tests the whole flow of schedule:add with prompts for an artisan command
     * It also tests that the user is prompted again in cases where input has
     * validation rules and fails.
     *
     *
     */
    public function should_prompt_for_all_questions_and_save_artisan_command_task()
    {
        $data = [
            'type' => TaskType::COMMAND->value,
            'task' => 'inspire --no-interaction',
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

        $this->artisan('schedule:add')
            ->expectsQuestion(trans('cli-scheduler::questions.type'), $data['type'])
            ->expectsQuestion(trans('cli-scheduler::questions.task.artisan'), 'invalid:command')
            ->expectsOutput(trans('cli-scheduler::messages.invalid_artisan_command', ['command' => 'invalid:command']))
            ->expectsQuestion(trans('cli-scheduler::questions.task.artisan'), $data['task'])
            ->expectsQuestion(trans('cli-scheduler::questions.description'), $data['description'])
            ->expectsQuestion(trans('cli-scheduler::questions.cron'), '* * *')
            ->expectsOutput(trans('cli-scheduler::messages.invalid_cron_expression', ['cron' => '* * *']))
            ->expectsQuestion(trans('cli-scheduler::questions.cron'), '* * * * *')
            ->expectsQuestion(trans('cli-scheduler::questions.timezone'), 'Invalid/Timezone')
            ->expectsOutput(trans('cli-scheduler::messages.invalid_timezone', ['timezone' => 'Invalid/Timezone']))
            ->expectsQuestion(trans('cli-scheduler::questions.timezone'), 'Australia/Sydney')
            ->expectsQuestion(trans('cli-scheduler::questions.environments'), implode(',', json_decode($data['environments'])))
            ->expectsQuestion(trans('cli-scheduler::questions.overlapping'), $this->mapToChoice($data['without_overlapping']))
            ->expectsQuestion(trans('cli-scheduler::questions.one_server'), $this->mapToChoice($data['on_one_server']))
            ->expectsOutput(trans('cli-scheduler::messages.cache_driver_alert'))
            ->expectsQuestion(trans('cli-scheduler::questions.maintenance'), $this->mapToChoice($data['in_maintenance_mode']))
            ->expectsQuestion(trans('cli-scheduler::questions.background'), $this->mapToChoice($data['run_in_background']))
            ->expectsQuestion(trans('cli-scheduler::questions.confirm_output_path'), true)
            ->expectsQuestion(trans('cli-scheduler::questions.output_path'), $data['output_path'])
            ->expectsQuestion(trans('cli-scheduler::questions.append_output'), $this->mapToChoice($data['append_output']))
            ->expectsQuestion(trans('cli-scheduler::questions.output_email'), $data['output_email'])
            ->assertExitCode(0);

        $this->assertDatabaseHas(config('cli-scheduler.table'), $data);
    }
}
