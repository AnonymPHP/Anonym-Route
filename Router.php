<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Route;
use Anonym\Components\HttpClient\Request;
/**
 * Class Router
 * @package Anonym\Components\Route
 */
class Router implements RouterInterface
{

    /**
     * the instance of RouteMatcherInterface
     *
     * @var RouteMatcherInterface
     */
    private $matcher;

    /**
     * The request currently dispatched
     *
     * @var Request
     */
    private $request;

    /**
     * the instance of ActionDispatcher
     *
     * @var ActionDispatcherInterface
     */
    private $actionDispatcher;

    /**
     * Create a new instance and set Request and matcher variables
     *
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->setRequest($request);
        $this->setMatcher(new RouteMatcher($this->getRequest()->getUrl()));
        $this->setActionDispatcher( new ActionDispatcher());
    }

    /**
     * @return RouteMatcherInterface
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * Set a route matcher instance
     *
     * @param RouteMatcherInterface $matcher
     * @return Router
     */
    public function setMatcher(RouteMatcherInterface $matcher)
    {
        $this->matcher = $matcher;
        return $this;
    }

    /**
     * return a route matcher interface
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return Router
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * return the action dispatcher
     *
     * @return ActionDispatcherInterface
     */
    public function getActionDispatcher()
    {
        return $this->actionDispatcher;
    }

    /**
     * Register the action dispatcher
     *
     * @param ActionDispatcherInterface $actionDispatcher
     * @return $this
     */
    public function setActionDispatcher(ActionDispatcherInterface $actionDispatcher)
    {
        $this->actionDispatcher = $actionDispatcher;
        return $this;
    }



    /**
     * Run the router and check requested uri
     *
     * @throws RouteMatchException
     * @return bool
     */
    public function run()
    {
        $collections = RouteCollector::getRoutes();
        $method = strtoupper($this->getRequest()->getMethod());

        if (isset($collections[$method])) {

            $collections = $collections[$method];

            foreach($collections as $collection)
            {
                if($this->getMatcher()->match($collection['uri']))
                {
                    $actionDispatcher = new ActionDispatcher();
                    $actionDispatcher->dispatch($collection['action']);
                    return true;
                }
            }

            throw new RouteMatchException('We dont\' have any matcher route');

        }else{

            throw new RouteMatchException(sprintf('There is no route in your %s method', $method));
        }
    }


}
