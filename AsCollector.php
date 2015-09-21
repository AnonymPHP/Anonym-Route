<?php
/**
 * This file belongs to the AnoynmFramework
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 * Thanks for using
 */

namespace Anonym\Components\Route;

/**
 * Class AsCollector
 * @package Anonym\Components\Route
 */
class AsCollector
{

    /**
     * the list of routes as
     *
     * @var array
     */
    protected static $as;


    /**
     * the name of routes
     *
     * @param string $as
     * @param string $url
     */
    public static function addAs($as, $url = '')
    {
        static::$as[$as] = $url;
    }

    /**
     * return registered routes
     *
     * @return array
     */
    public static function getAs()
    {
        return self::$as;
    }

    /**
     * register as list
     *
     * @param array $as
     */
    public static function setAs($as)
    {
        self::$as = $as;
    }

}
