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
 * the class of access bag
 *
 * Class AccessBag
 * @package Anonym\Components\Route
 */
class AccessBag
{

    /**
     * to store the complate list of  access classes
     *
     * @var array
     */
    private static $accesses;

    /**
     * return the registered accesses
     *
     * @return array
     */
    public static function getAccesses()
    {
        return self::$accesses;
    }

    /**
     * register the access list
     *
     * @param array $accesses
     */
    public static function setAccesses($accesses)
    {
        self::$accesses = $accesses;
    }

}
