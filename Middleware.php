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
     * check's the user authority
     *
     * @param string $name the middleware name
     * @throws MiddlewareException
     * @return bool
     */
    public function middleware($name = '')
    {
        if (!$this->accessDispatcher) {
            $this->accessDispatcher = new AccessDispatcher();
        }

        $middleware =  $this->accessDispatcher->process($name);

        if(true !== $middleware)
        {
            throw new MiddlewareException('You can\'t access here, your authority is incorrect');
        }

        return true;
    }

}