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
 * the class of controller exception
 *
 * Class ControllerException
 * @package Anonym\Components\Route
 */
class ControllerException extends Exception
{
    /**
     * throw a new exception with message string
     *
     * @param string $message the message of exception
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }
}
