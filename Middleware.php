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

use Closure;

/**
 * the trait of middleware
 *
 * Trait Middleware
 * @package Anonym\Components\Route
 */
trait Middleware
{

    /**
     * the instance of access dispatcher
     *
     * @var AccessDispatcherInterface
     */
    private $accessDispatcher;

    /**
     *  determine user authentication
     *
     * @param string $name the middleware name
     * @param string|array $role the role of user, can be string or array
     * @param Closure $next the callback for middleware
     * @throws MiddlewareException
     * @return bool
     */
    public function middleware($name = '', $role = '', Closure $next = null)
    {
        if (!$this->accessDispatcher) {
            $this->accessDispatcher = new AccessDispatcher();
        }

        $middleware = $this->accessDispatcher->process([
            'name' => $name,
            'role' => $role,
            'next' => $next
        ]);

        if (true !== $middleware) {
            throw new MiddlewareException('You can\'t access here, your authority is incorrect');
        }

        return true;
    }

}
