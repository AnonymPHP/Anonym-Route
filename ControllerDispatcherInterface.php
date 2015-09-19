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
 * Interface ControllerDispatcherInterface
 * @package Anonym\Components\Route
 */
interface ControllerDispatcherInterface
{

    /**
     * dispatch the controller
     *
     * @return \Anonym\Components\Route\Controller
     */
    public function dispatch();
}
