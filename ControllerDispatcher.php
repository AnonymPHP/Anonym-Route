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
 * Class ControllerDispatcher
 * @package Anonym\Components\Route
 */
class ControllerDispatcher implements ControllerDispatcherInterface
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

    /**
     * dispatch the controller
     *
     * @throws ControllerException
     * @return \Anonym\Components\Route\Controller
     */
    public function dispatch()
    {
        $name = $this->namespace . $this->class;

        $controller = new $name;

        if($controller instanceof Controller)
        {
            $controller->setParameters(ParameterBag::getParameters());
            return $controller;
        }else{
            throw new ControllerException(sprintf('%s is not a controller', $name));
        }
    }
}