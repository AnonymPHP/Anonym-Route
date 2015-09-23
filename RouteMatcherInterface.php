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
 * Interface RouteMatcherInterface
 * @package Anonym\Components\Route
 */
interface RouteMatcherInterface
{

    /**
     * Eşleşmeyi yapar
     *
     * @param string $matchUrl
     * @return bool
     */
    public function match($matchUrl = null);


    /**
     *
     * Urller aynı ise direk döndürüyor
     *
     * @param string $url
     * @return bool
     */
    public function isUrlEqual($url = null);
}
