<?php

namespace Koomai\CliScheduler\Console\Commands;

use Illuminate\Console\Command;
use Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface;

abstract class ScheduleCommand extends Command
{
    protected ScheduledTaskRepositoryInterface $repository;

    public function __construct(ScheduledTaskRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }
}
