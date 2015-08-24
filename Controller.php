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
 * the parent class of controllers
 *
 * Class Controller
 * @package Anonym\Components\Route
 */
abstract class Controller
{
    use Middleware;

    /**
     * repository of parameters
     *
     * @var array
     */
    private $parameters;
}
