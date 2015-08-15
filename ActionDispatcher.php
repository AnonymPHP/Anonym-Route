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
     * the instance of access dispatcher
     *
     * @var AccessDispatcherInterface
     */
    private $accessDispatcher;

    /**
     * create a new instance and register the default namespace
     *
     * @param string $namespace
     * @param array $access the list of access
     * @param Request $request the instance of request
     */
    public function __construct($namespace = '', array $access = [], Request $request = null)
    {
        $this->namespace = $namespace;
        AccessBag::setAccesses($access);
        AccessBag::setRequest($request);
        $this->setAccessDispatcher( new AccessDispatcher());

    }

    /**
     * Dispatch a action from array
     *
     * @param array|string $action
     * @return mixed
     */
    public function dispatch($action = [])
    {

        if (is_string($action)) {
            $action = [
                '_controller' => $action
            ];
        }

        if (isset($action['_controller'])) {
            $controller = $action['_controller'];

            if (strstr($controller, ':')) {
                list($controller, $method) = explode(':', $controller);
            } elseif ($action['_method']) {
                $method = $action['_method'];
            }
        }

        if (isset($action['_access'])) {

            if (false === $this->getAccessDispatcher()->process($action['_access'])) {
                return false;
            }

        }

        $controller = $this->createControllerInstance($controller);
        $response = $this->callControllerMethod($controller, $method);

        return $this->handleResponse($response);

    }

    /**
     * Handler the controller returned value
     *
     * @param ViewExecuteInterface|Response|Request|string $response
     * @return string|bool
     */
    private function handleResponse($response)
    {

        if ($response instanceof ViewExecuteInterface) {
            $content = $response->execute();
        } elseif ($response instanceof Response) {
            $content = $response->getContent();
        } elseif ($response instanceof Request) {
            $content = $response->getResponse()->getContent();
        } elseif (is_string($response)) {
            $content = $response;
        } else {
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
        $controllerName = $this->namespace . $controller;
        $controller = new $controllerName;

        if ($controller instanceof Controller) {
            return $controller;
        } else {
            throw new ControllerException(sprintf('%s is not a controller', $controllerName));
        }
    }


    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return ActionDispatcher
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return AccessDispatcherInterface
     */
    public function getAccessDispatcher()
    {
        return $this->accessDispatcher;
    }

    /**
     * @param AccessDispatcherInterface $accessDispatcher
     * @return ActionDispatcher
     */
    public function setAccessDispatcher(AccessDispatcherInterface $accessDispatcher)
    {
        $this->accessDispatcher = $accessDispatcher;
        return $this;
    }


}
