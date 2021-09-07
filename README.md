# Laravel CLI Scheduler  

Dynamically schedule your [Laravel tasks](https://laravel.com/docs/scheduling) using artisan commands.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/koomai/laravel-cli-scheduler.svg?style=flat-square)](https://packagist.org/packages/koomai/laravel-cli-scheduler)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/koomai/laravel-cli-scheduler/run-tests?label=tests)](https://github.com/koomai/laravel-cli-scheduler/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/koomai/laravel-cli-scheduler/Check%20&%20fix%20styling?label=code%20style)](https://github.com/koomai/laravel-cli-scheduler/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/koomai/laravel-cli-scheduler.svg?style=flat-square)](https://packagist.org/packages/koomai/laravel-cli-scheduler)

Laravel Scheduler allows you to add, view and remove scheduled tasks in a database via artisan commands. This is particularly useful when you want to schedule tasks without having to redeploy code.


## Installation

You can install the package via composer:

```bash
composer require koomai/laravel-cli-scheduler
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Koomai\CliScheduler\LaravelCliSchedulerServiceProvider" --tag="laravel-cli-scheduler-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Koomai\CliScheduler\LaravelCliSchedulerServiceProvider" --tag="laravel-cli-scheduler-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

### Add Scheduled Task

`php artisan schedule:add`

### List scheduled tasks (in database)

`php artisan schedule:list`

### Show/Delete a scheduled task (in database)

`php artisan schedule:show <id>`

`php artisan schedule:delete <id>`

### Show due scheduled tasks (from both database and `Console\Kernel`)

`php artisan schedule:due`

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sid K](https://github.com/koomai)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
