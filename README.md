# Human Cron

## Installation

First, pull in the package through Composer.

```js
composer require appsketch/human-cron
```

And then, if using Laravel 5.1, include the service provider within `app/config/app.php`.

```php
'providers' => [
    Appsketch\HumanCron\Providers\HumanCronServiceProvider::class,
]
```

if using Laravel 5. include this service provider.

```php
'providers' => [
    "Appsketch\HumanCron\Providers\HumanCronServiceProvider",
]
```

The alias will automatically set.

## Usage

Within, for example the routes.php add this.

```php
Route::get('/cron', function()
{
    // Cron
    $cron = '0,30 * * * * *';
    
    // Will echo e.g. '1 minute from now'
    echo HumanCron::cron($cron)->next();
    
    // Will echo e.g. '2 minutes ago'
    echo HumanCron::cron($cron)->previous();
    
    // Will print an array with both; next and previous.
    print_r(HumanCron::cron($cron)->both());
});
```