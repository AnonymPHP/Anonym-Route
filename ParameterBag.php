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
     * Parametreleri tutar
     *
     * @var array
     */
    private static $parameters;


    /**
     * Parametre eklemesi yapar
     *
     * @param string $name
     * @param string $value
     */
    public function addParameter($name, $value = '')
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
        self::$parameters = $parameters;
    }

}
