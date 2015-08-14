<?php
/**
 * This file belongs to the AnonymFramework
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 * Thanks for using
 */


namespace Anonym\Components\Route;

/**
 * the class of action dispatcher
 *
 * Class ActionDispatcher
 * @package Anonym\Components\Route
 */
class ActionDispatcher implements ActionDispatcherInterface
{


    /**
     * default namespace of the controllers
     *
     * @var string
     */
    private $namespace;

    public function __construct($namespace = '')
    {

        $this->namespace = $namespace;
    }

    /**
     * Dispatch a action from array
     *
     * @param array $action
     * @return mixed
     */
    public function dispatch(array $action = [])
    {
        if (isset($action['_controller'])) {
            $controller = $action['_controller'];

            if(strstr($controller,':'))
            {
                list($controller, $method) = explode(':', $controller);
            }elseif($action['_method'])
            {
                $method = $action['_method'];
            }
        }

        $controller = $this->createControllerInstance($controller);

    }

    /**
     * Create a new controller instance with controller name
     *
     * @param string $controller the controller name
     * @return Controller
     */
    private function createControllerInstance($controller = '')
    {

    }
}
