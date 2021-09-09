<?php

namespace Koomai\CliScheduler\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Koomai\CliScheduler\CliSchedulerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            CliSchedulerServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        // Setup default database as testing to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        // Set table name
        $app['config']->set('cli-scheduler.table', 'scheduled_tasks');
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
