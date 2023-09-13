# Laravel CLI Scheduler  

Dynamically schedule your [Laravel tasks](https://laravel.com/docs/scheduling) using artisan commands.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/koomai/laravel-cli-scheduler.svg?style=flat-square)](https://packagist.org/packages/koomai/laravel-cli-scheduler)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/koomai/laravel-cli-scheduler/PHPUnit?label=tests&style=flat-square)](https://github.com/koomai/laravel-cli-scheduler/actions/workflows/run-tests.yml?query=branch%3Amain)
[![GitHub Psalm Action Status](https://img.shields.io/github/workflow/status/koomai/laravel-cli-scheduler/Psalm?label=psalm&style=flat-square)](https://github.com/koomai/laravel-cli-scheduler/actions/workflows/psalm.yml?query=branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/koomai/laravel-cli-scheduler/PHP%20CS%20Fixer?label=code%20style&style=flat-square)](https://github.com/koomai/laravel-cli-scheduler/actions/workflows/php-cs-fixer.yml?query=branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/koomai/laravel-cli-scheduler.svg?style=flat-square)](https://packagist.org/packages/koomai/laravel-cli-scheduler)

Laravel Scheduler allows you to add, view and remove scheduled tasks in a database via artisan commands. This is particularly useful when you want to schedule tasks without having to redeploy code.


## Installation

Install the package via composer:

```bash
composer require koomai/laravel-cli-scheduler
```

You will need to publish the config file to customise the table name and/or setup default values for some options.

```bash
php artisan vendor:publish -tag="cli-scheduler-config"
```

## Usage

### Add Scheduled Task

`php artisan schedule:add`

### List scheduled tasks (in the database)

`php artisan schedule:list-tasks`

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
- [Spatie Package Skeleton](https://github.com/spatie/package-skeleton-laravel)  
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
