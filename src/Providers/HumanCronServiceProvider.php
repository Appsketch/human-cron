<?php

namespace Appsketch\HumanCron\Providers;

use Appsketch\HumanCron\HumanCron;
use Carbon\Carbon;
use Cron\CronExpression;
use Cron\FieldFactory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class HumanCronServiceProvider
 *
 * @package Appsketch\HumanCron\Providers
 */
class HumanCronServiceProvider extends ServiceProvider
{
    /**
     * Indicates of loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register bindings.
        $this->registerBindings();

        // Register Human Cron.
        $this->registerHumanCron();

        // Alias Human Cron.
        $this->aliasHumanCron();
    }

    /**
     * Register bindings.
     */
    private function registerBindings()
    {
        // Instance Carbon.
        $this->app->instance('Carbon\Carbon', new Carbon());

        // Instance FieldFactory.
        $this->app->instance('Cron\FieldFactory', new FieldFactory());

        // Instance Cron Expression.
        $this->app->singleton('Cron\CronExpression', function($app)
        {
            return new CronExpression('* * * * * *', $app['Cron\FieldFactory']);
        });
    }

    /**
     * Register Human Cron
     */
    private function registerHumanCron()
    {
        // Bind HumanCron.
        $this->app->bind('Appsketch\HumanCron\HumanCron', function($app)
        {
            return new HumanCron($app['Carbon\Carbon'], $app['Cron\CronExpression'], $app['config']);
        });
    }

    /**
     * Alias Human Cron
     */
    private function aliasHumanCron()
    {
        // Check if alias doesn't exists.
        if(!$this->aliasExists('HumanCron'))
        {
            // Create alias.
            AliasLoader::getInstance()->alias(
                'HumanCron',
                \Appsketch\HumanCron\Facades\HumanCron::class
            );
        }
    }

    /**
     * Check if an alias already exists in the IOC.
     *
     * @param $alias
     *
     * @return bool
     */
    private function aliasExists($alias)
    {
        return array_key_exists($alias, AliasLoader::getInstance()->getAliases());
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Appsketch\HumanCron\HumanCron',
            'Carbon\Carbon',
            'Cron\CronExpression'
        ];
    }
}
