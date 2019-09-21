<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Koomai\CliScheduler\Enums\TaskType;
use Koomai\CliScheduler\ScheduledTask;

$factory->define(
    ScheduledTask::class,
    function (Faker\Generator $faker) {
        return [
            'type' => TaskType::COMMAND,
            'task' => 'cache:clear --quiet',
            'description' => 'Test description',
            'cron' => '* * * * *',
            'timezone' => 'Australia/Sydney',
            'environments' => '[]',
        ];
    }
);
