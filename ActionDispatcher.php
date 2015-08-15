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
     * The all access list
     *
     * @var array
     */
    private $access;

    /**
     * the instance of current request
     *
     * @var Request
     */
    private $request;

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
        $this->access = $access;
        $this->request = $request;
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

            if (strstr($controller, ':')) {
                list($controller, $method) = explode(':', $controller);
            } elseif ($action['_method']) {
                $method = $action['_method'];
            }
        }


        if (isset($action['_access'])) {

            if (false === $this->processAccess($action['_access'])) {
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
     * Process the user access
     *
     * @param array $access the content of access
     * @return bool
     */
    private function processAccess(array $access)
    {
        if (is_string($access)) {
            if (isset($access['name'])) {
                $name = $access['name'];

                if (isset($this->access[$name])) {
                    $accessInstance = $this->access[$name];
                    $accessInstance = new $accessInstance;
                }
            }
        }

        if ($accessInstance instanceof AccessInterface) {

            $role = isset($access['role']) ? $access['role'] : '';
            $next = isset($access['next']) ? $access['next'] : null;
            if ($accessInstance->handle($this->request, $role, $next)) {
                return true;
            }
        }

        return false;
    }
}
