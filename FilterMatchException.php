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
 * Class FilterMatchException
 * @package Anonym\Components\Route
 */
class FilterMatchException extends Exception
{

    /**
     * create a new instance and register exception message
     *
     * @param string $message
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }
}
