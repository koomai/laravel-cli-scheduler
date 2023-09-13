<?php

namespace Koomai\CliScheduler\Enums;

enum TaskType: string
{
    case COMMAND = 'Command';
    case JOB = 'Job';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
