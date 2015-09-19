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
 *  A interface for Router
 *
 * Interface RouterInterface
 * @package Anonym\Components\Route
 */
interface RouterInterface
{

    /**
     * Run the router and check requested uri
     *
     * @return bool
     */
    public function run();

}

