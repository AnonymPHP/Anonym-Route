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
use Anonym\Facades\App;
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

        $name = $this->generateClassName($this->namespace, $this->class);

        // the controller instance
        $controller = App::make($name);


        if($controller instanceof Controller)
        {
            // register the parameters
            $controller->setParameters(ParameterBag::getParameters());

            // return the instance
            return $controller;
        }else{
            throw new ControllerException(sprintf('%s is not a controller', $name));
        }
    }

    /**
     * generate the full class name
     *
     * @param string $namespace
     * @param string $class
     * @return string
     */
    private function generateClassName($namespace = '', $class = '')
    {
        return $this->resolveNamespacePath($namespace).$class;
    }

    /**
     * resolve the namespace path
     *
     * @param string $namespace
     * @return string
     */
    private function resolveNamespacePath($namespace = '')
    {
        if (substr($namespace, -1) !== '\\') {
            $namespace .= '\\';
        }

        return $namespace;
    }
}
