<?php
namespace Anonym\Components\Route;

/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */

class ParameterBag
{

    /**
     * Store the parameters
     *
     * @var array
     */
    private static $parameters = [];

    /**
     * add a parameter with name and value
     *
     * @param string $name the name of parameter
     * @param mixed $value the value of parameter, can be anything
     */
    public static function addParameter($name, $value = '')
    {
        static::$parameters[$name] = $value;
    }
    /**
     * Parametreleri döndürür
     *
     * @return array
     */
    public static function getParameters()
    {
        return self::$parameters;
    }

    /**
     * Parametreleri ayarlar
     *
     * @param array $parameters
     */
    public static function setParameters($parameters)
    {
        self::$parameters = array_merge(static::$parameters, $parameters);
    }

}
