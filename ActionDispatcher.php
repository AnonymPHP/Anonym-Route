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

use Anonym\Components\HttpClient\Request;
use Anonym\Components\HttpClient\Response;
use Anonym\Components\View\ViewExecuteInterface;

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

    /**
     * create a new instance and register the default namespace
     *
     * @param string $namespace
     */
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
        $response = $this->callControllerMethod($controller, $method);


        return $this->handleResponse($response);

    }

    /**
     * Handler the controller returned value
     *
     * @param $response
     * @return string|bool
     */
    private function handleResponse($response)
    {

        if($response instanceof ViewExecuteInterface)
        {
            $content = $response->execute();
        }elseif($response instanceof Response)
        {
            $content = $response->getContent();
        }elseif($response instanceof Request)
        {
            $content = $response->getResponse()->getContent();
        }elseif(is_string($response)){
            $content = $response;
        }else{
            $content = false;
        }

        return $content;
    }

    /**
     * Call the method of controller
     *
     * @param Controller $controller the instance of controller
     * @param string $method the name of a controller method
     * @return mixed
     */
    private function callControllerMethod(Controller $controller, $method)
    {
        return call_user_func_array([$controller, $method], ParameterBag::getParameters());
    }

    /**
     * Create a new controller instance with controller name
     *
     * @param string $controller the controller name
     * @throws ControllerException
     * @return Controller
     */
    private function createControllerInstance($controller = '')
    {
        $controllerName = $this->namespace.$controller;
        $controller = new $controllerName;

        if($controller instanceof Controller)
        {
            return $controller;
        }else{
            throw new ControllerException(sprintf('%s is not a controller', $controllerName));
        }
    }
}
