<?php

namespace Appsketch\HumanCron\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class HumanCron
 *
 * @package Appsketch\HumanCron\Facades
 */
class HumanCron extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Appsketch\HumanCron\HumanCron';
    }
}