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

use Exception;

/**
 * the exception to middleware
 *
 * Class MiddlewareException
 * @package Anonym\Components\Route
 */
class MiddlewareException extends Exception
{

    /**
     * send the exception message
     *
     * @param string $message the exception message
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

}
