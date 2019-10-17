<?php

namespace Koomai\CliScheduler\Console\Commands\Traits;

use Koomai\CliScheduler\ScheduledTask;
use Symfony\Component\Console\Helper\TableSeparator;

trait BuildsScheduledTasksTable
{
    protected $headers = [
        'Id',
        'Type',
        'Task',
        'Description',
        'Cron',
        'Environments',
        'Queue',
        'Output',
        'Other',
    ];

    /**
     * Builds a table from one or more models.
     *
     * @param $tasks
     */
    protected function generateTable($tasks)
    {
        // Create a collection if the argument is a single model
        if ($tasks instanceof ScheduledTask) {
            $tasks = collect([$tasks]);
        }

        $separator = new TableSeparator();
        $attributes = $tasks
            ->flatMap(function ($task) use ($separator) {
                return [
                    [
                        $task->id,
                        $task->type,
                        $task->task,
                        $task->description ?? 'N/A',
                        $task->cron,
                        implode(',', $task->environments) ?: 'N/A',
                        $task->queue ?? 'N/A',
                        $this->listOutputOptions($task),
                        $this->listOtherOptions($task),
                    ],
                    $separator,
                ];
            });

        // Remove the last separator
        $attributes->pop();

        $this->table($this->headers, $attributes, 'box');
    }

    private function listOutputOptions($task)
    {
        return
            'Output Path: ' . ($task->output_path ?: '<fg=yellow>N/A</>') . "\n" .
            'Append Output: ' . ($task->append_output ? '<fg=green>Yes</>' : '<fg=red>No</>') . "\n" .
            'Output Email: ' . ($task->output_email ?? '<fg=yellow>N/A</>');
    }

    private function listOtherOptions($task)
    {
        return
            'Timezone: <fg=yellow>' . ($task->timezone ?? config('app.timezone')) . "</>\n" .
            'Without Overlapping: ' . ($task->without_overlapping ? '<fg=green>Yes</>' : '<fg=red>No</>') . "\n" .
            'On One Server: ' . ($task->one_one_server ? '<fg=green>Yes</>' : '<fg=red>No</>') . "\n" .
            'Run in Background: ' . ($task->run_in_background ? '<fg=green>Yes</>' : '<fg=red>No</>') . "\n" .
            'In Maintenance Mode: ' . ($task->in_maintenance_mode ? '<fg=green>Yes</>' : '<fg=red>No</>');
    }
}
