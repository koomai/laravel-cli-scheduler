<?php

namespace Koomai\CliScheduler\Enums;

use BenSampo\Enum\Enum;

final class TaskType extends Enum
{
    public const COMMAND = 'Command';
    public const JOB = 'Job';
}
