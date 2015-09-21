<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Route;

/**
 * Class RouteCollector
 * @package Anonym\Components\Route
 */
class RouteCollector
{

    /**
     * All routes
     *
     * @var array
     */
    private static $routes = [];


    /**
     * All group collections
     *
     * @var array
     */
    private static $groups = [];

    /**
     * the last fired group collection
     *
     * @var array
     */
    public static $firing;

    /**
     * All verbs supported by router
     *
     * @var array
     */
    private $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * Add a route with type, uri and action parameters
     *
     * @param string|array $types
     * @param array $uri
     * @param array $action
     * @return $this
     */
    private function addRoute($types = '', $uri, $action = [])
    {

        if (is_string($action)) {
            $action = ['_controller' => $action];
        }

        if (is_array($action)) {
            if (isset($action['as'])) {
                AsCollector::addAs($action['as'], $uri);
            }
        }

        $types = (array)$types;

        foreach ($types as $type) {
            $type = mb_convert_case($type, MB_CASE_UPPER);

            $add = [
                'uri' => isset(static::$firing['when']) ? $this->createWhenUri($uri) : $uri,
                'action' => $action
            ];;

            // add group parameter to action variable
            if (static::$firing['group']) {
                $add['group'] = static::$firing['group'];
            }

            // add to collection
            static::$routes[$type][] = $add;
        }
        return $this;
    }

    /**
     * prapare uri to merge with when url, and return it.
     *
     * @param string $uri
     * @return string
     */
    protected function createWhenUri($uri)
    {
        $when = static::$firing['when'];

        if (substr($when, -1) !== '/') {
            $when .= '/';
        }

        if(substr($uri, 0,1) === '/'){
            $uri = substr($uri, 1, strlen($uri));
        }

        return $when.$uri;
    }

    /**
     * Register a new GET route with router
     *
     * @param string $uri
     * @param mixed $action
     * @return $this
     */
    public function get($uri, $action)
    {
        return $this->addRoute(['GET', 'HEAD'], $uri, $action);
    }

    /**
     * Register a new POST route with router
     *
     * @param string $uri
     * @param mixed $action
     * @return $this
     */
    public function post($uri, $action)
    {
        return $this->addRoute(['POST'], $uri, $action);
    }


    /**
     * Register a new PUT route with router
     *
     * @param string $uri
     * @param mixed $action
     * @return $this
     */
    public function put($uri, $action)
    {
        return $this->addRoute(['PUT'], $uri, $action);
    }


    /**
     * Register a new DELETE route with router
     *
     * @param string $uri
     * @param mixed $action
     * @return $this
     */
    public function delete($uri, $action)
    {
        return $this->addRoute(['DELETE'], $uri, $action);
    }


    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string $uri
     * @param  \Closure|array|string $action
     * @return $this
     */
    public function options($uri, $action)
    {
        return $this->addRoute('OPTIONS', $uri, $action);
    }

    /**
     * Register a new route responding to all verbs.
     *
     * @param  string $uri
     * @param  \Closure|array|string $action
     * @return $this
     */
    public function any($uri, $action)
    {
        return $this->addRoute($this->getVerbs(), $uri, $action);
    }

    /**
     * Register a new route with the given verbs.
     *
     * @param  array|string $methods
     * @param  string $uri
     * @param  \Closure|array|string $action
     * @return $this
     */
    public function match($methods, $uri, $action)
    {
        return $this->addRoute($methods, $uri, $action);
    }

    /**
     * Register a new PATCH route with router
     *
     * @param string $uri
     * @param mixed $action
     * @return $this
     */
    public function patch($uri, $action)
    {
        return $this->addRoute(['PATCH'], $uri, $action);
    }

    /**
     * Register a new WHEN route with router
     *
     * @param string $uri
     * @param mixed $action
     * @return $this
     */
    public function when($uri, $action)
    {
        return $this->addRoute('WHEN', $uri, $action);
    }


    /**
     * register a new group collection
     *
     * @param string $name
     * @param array $action
     * @param Closure $callback
     * @return $this
     */
    public function group($name, $action, Closure $callback)
    {
        static::$groups[$name] = [
            'action' => $action,
            'callback' => $callback
        ];

        return $this;
    }

    /**
     * return called group
     *
     * @return array
     */
    public static function firing()
    {
        return static::$firing;
    }

    /**
     * Register a new filter with name and type
     *
     * @param string $name The name of filter
     * @param string $type The type of filter
     * @return $this
     */
    public function filter($name, $type = '')
    {
        FilterBag::addFilter($name, $type);
        return $this;
    }

    /**
     * Return added routes
     *
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Set routes from array
     *
     * @param array $routes
     */
    public static function setRoutes(array $routes)
    {
        self::$routes = $routes;
    }

    /**
     * Return all verbs
     *
     * @return array
     */
    public function getVerbs()
    {
        return $this->verbs;
    }

    /**
     * Set verbs from array
     *
     * @param array $verbs
     */
    public function setVerbs(array $verbs)
    {
        $this->verbs = $verbs;
    }

    /**
     * @return array
     */
    public static function getGroups()
    {
        return self::$groups;
    }

    /**
     * @param array $groups
     */
    public static function setGroups($groups)
    {
        self::$groups = $groups;
    }

}
