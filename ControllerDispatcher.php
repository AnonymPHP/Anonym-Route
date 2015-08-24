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


class ControllerDispatcher
{

    /**
     * the namespace of controller
     *
     * @var string
     */
    private $namespace;

    /**
     * the name of class
     *
     * @var string
     */
    private $class;


    public function __construct($namespace, $class)
    {
        $this->namespace = $namespace;
        $this->class = $class;

    }

}