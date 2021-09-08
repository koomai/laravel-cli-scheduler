<?php

namespace Koomai\CliScheduler\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Koomai\CliScheduler\ScheduledTask;

class StartingScheduledTask
{
    use Dispatchable;
    use SerializesModels;

    /**
     * @var \Koomai\CliScheduler\ScheduledTask
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param \Koomai\CliScheduler\ScheduledTask $task
     */
    public function __construct(ScheduledTask $task)
    {
        $this->task = $task;
    }
}
