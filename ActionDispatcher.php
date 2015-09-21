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
use Closure;
use Anonym\Facades\App;
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
     * the group variables
     *
     * @var array
     */
    private $group;


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
        AccessBag::setRequest($request);
        $this->setAccessDispatcher(new AccessDispatcher());

    }

    /**
     * register group
     *
     * @param null|array $group
     * @param array|string $action
     */
    protected function registerGroup($group = null, $action = []){
        if($group !== null){
            $this->group = $group;
        }elseif(isset($action['_group'])){
            $this->group = $action['_group'];
        }
    }
    /**
     * Dispatch a action from array
     *
     * @param array|string $action
     * @param array|null $group
     * @return mixed
     */
    public function dispatch($action = [], $group = null)
    {


        // convert string type to array
        if (is_string($action)) {
            $action = [
                '_controller' => $action
            ];
        }


        // find and register route group
        $this->registerGroup($group, $action);

        if (is_array($action)) {

            list($controller, $method, $namespace) = $this->findControllerAndMethod($action);

            // find and run middleware
            if ($middleware = $this->findMiddleware($action)) {
                if (false === $this->runMiddleware($middleware)) {
                    return false;
                }
            }

            // register the namespace
            isset($namespace) ? $this->setNamespace($namespace) : null;

            // create a controller instance
            $controller = $this->createControllerInstance($controller);

            // call the method
            $response = $this->callControllerMethod($controller, $method);
            return $this->handleResponse($response);

        } elseif ($action instanceof Closure) {
            return $this->handleResponse(app()->call($action, ParameterBag::getParameters()));
        } else {
            return false;
        }
    }

    /**
     * find and return middleware
     *
     * @param array $action
     * @return mixed
     */
    protected function findMiddleware(array $action)
    {
        if (isset($action['_middleware'])) {
            return $action['_middleware'];
        } elseif (isset($this->group['_middleware'])) {
            return $this->group['_middleware'];
        }

        return false;
    }

    /**
     * return user middleware with given variables
     *
     * @param array $middleware
     * @return bool
     */
    protected function runMiddleware(array $middleware)
    {
        return $this->getAccessDispatcher()->process($middleware);
    }

    /**
     * find controller, method and namespace in action variable
     *
     * @param array $action
     * @return array
     * @throws ControllerException
     */
    protected function findControllerAndMethod(array $action)
    {
        if (isset($action['_controller']) || $action['uses']) {
            $controller = isset($action['_controller']) ? $action['_controller'] : $action['uses'];

            if (strstr($controller, ':')) {
                list($controller, $method) = explode(':', $controller);
            } elseif ($action['_method']) {
                $method = $action['_method'];
            }

            $namespace = $this->findNamespaceInController($controller);

            return [$controller, $method, $namespace];

        } else {
            throw new ControllerException('Your controller variable could not found in your route');
        }
    }

    /**
     * find namespace in controller
     *
     * @param string $controller
     * @return array|string
     */
    protected function findNamespaceInController(&$controller)
    {
        if (strstr('\\', $controller)) {
            $namespace = explode('\\', $controller);
            $controller = end($namespace);
            $namespace = rtrim(join('\\', array_slice($namespace, 0, count($namespace) - 1)), '\\');
        } else {
            $namespace = isset($this->group['_namespace']) ? $this->group['namespace'] : null;
        }

        return $namespace;
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
        return App::call([$controller, $method], ParameterBag::getParameters());
    }

    /**
     * Create a new controller instance with controller name
     *
     * @param string $controller the controller name
     * @return Controller the instance of controller
     */
    private function createControllerInstance($controller = '')
    {
        $controller = new ControllerDispatcher($this->getNamespace(), $controller);
        return $controller->dispatch();
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
