<?php

namespace Appsketch\HumanCron;

use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Support\Facades\Config;

/**
 * Class HumanCron
 *
 * @package Appsketch\HumanCron
 */
class HumanCron
{
    /**
     * @var Carbon
     */
    private $carbon;
    /**
     * @var CronExpression
     */
    private $expression;
    /**
     * @var
     */
    private $config;

    /**
     * @var
     */
    private $cron = '* * * * * *';

    /**
     * @param Carbon         $carbon
     * @param CronExpression $expression
     * @param                $config
     */
    public function __construct(Carbon $carbon, CronExpression $expression, $config)
    {
        $this->carbon     = $carbon;
        $this->expression = $expression;
        $this->config     = $config;

        // Set the Carbon locale.
        $this->setLocale();
    }

    /**
     * @param string $cron
     *
     * @return $this
     */
    public function cron($cron)
    {
        $this->cron = $cron;

        return $this;
    }

    /**
     * Get the previous run date.
     *
     * @return string
     */
    public function previous()
    {
        // Return the previous run date.
        return $this->timestring('getPreviousRunDate');
    }

    /**
     * Get the next run date.
     *
     * @return string
     */
    public function next()
    {
        // Return the next run date.
        return $this->timestring('getNextRunDate');
    }

    /**
     * Get an array with the previous and the next runtime.
     *
     * @return array
     */
    public function both()
    {
        return [
            'previous' => $this->previous(),
            'next'     => $this->next(),
        ];
    }

    /**
     * @param $rundate
     *
     * @return string
     */
    private function timestring($rundate)
    {
        // The timestamp format.
        $format = 'Y-m-d H:i:s';

        // Get the date.
        $date = $this->expression->factory($this->cron)->{$rundate}()->format($format);

        // Convert it to carbon.
        $carbon = $this->carbon->createFromFormat($format, $date);

        // Return the difference for humans.
        return $carbon->diffForHumans();
    }

    /**
     * Set the carbon locale.
     */
    private function setLocale()
    {
        // Get the locale from the app config file.
        $locale = $this->config->get('app.locale');

        // Check if it is set and not empty.
        if(isset($locale) && !empty($locale))
        {
            // Set the carbon locale.
            $this->carbon->setLocale($locale);
        }

    }
}