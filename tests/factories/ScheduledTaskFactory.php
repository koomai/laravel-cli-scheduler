<?php

namespace Koomai\CliScheduler\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Koomai\CliScheduler\Enums\TaskType;
use Koomai\CliScheduler\ScheduledTask;

class ScheduledTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScheduledTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => TaskType::COMMAND,
            'task' => 'cache:clear --quiet',
            'description' => 'Test description',
            'cron' => '* * * * *',
            'timezone' => 'Australia/Sydney',
            'environments' => '[]',
        ];
    }
}


