<?php

namespace Koomai\CliScheduler\Console\Commands;

use Illuminate\Console\Command;
use Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface;

abstract class ScheduleCommand extends Command
{
    /**
     * @var \Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new command instance.
     *
     * @param \Koomai\CliScheduler\Contracts\ScheduledTaskRepositoryInterface $repository
     */
    public function __construct(ScheduledTaskRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }
}
