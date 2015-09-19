<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Route;

/**
 * Class FilterBag
 * @package Anonym\Components\Route
 */
class FilterBag
{
    /**
     * All filters
     *
     * @var array
     */
    private static $filters = [];

    /**
     * @return array
     */
    public static function getFilters()
    {
        return self::$filters;
    }

    /**
     * @param array $filters
     */
    public static function setFilters($filters)
    {
        self::$filters = $filters;
    }

    /**
     * Yeni bir filtre ekler
     *
     * @param string $name
     * @param string $value
     */
    public static function addFilter($name, $value = '')
    {
        static::$filters[$name] = $value;
    }
}
