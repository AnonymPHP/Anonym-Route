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
use Anonym\Components\HttpClient\Request;
/**
 * the class of access dispatcher
 *
 * Class AccessDispatcher
 * @package Anonym\Components\Route
 */
class AccessDispatcher implements AccessDispatcherInterface
{

    /**
     * to store the complate list of registered access classes
     *
     * @var array
     */
    private $access = [];

    /**
     * the instance of request
     *
     * @var Request
     */
    private $request;

    /**
     * create a new instance and register the access array
     */
    public function __construct()
    {
        $this->access =  AccessBag::getAccesses();
        $this->request = AccessBag::getRequest();
    }

    /**
     * Process the array
     *
     * @param string $access the array of route access
     * @return bool
     */
    public function process($access = '')
    {
        if (is_array($access)) {
            if (isset($access['name'])) {
                $name = $access['name'];

                if (isset($this->access[$name])) {
                    $accessInstance = $this->access[$name];
                    $accessInstance = new $accessInstance;

                    if ($accessInstance instanceof MiddlewareInterface) {

                        $role = isset($access['role']) ? $access['role'] : '';
                        $next = isset($access['next']) ? $access['next'] : null;
                        if ($accessInstance->handle($this->request, $role, $next)) {
                            return true;
                        }else{
                            if ($accessInstance instanceof TerminateInterface) {
                                $accessInstance->terminate($this->request);
                            }
                        }
                    }
                }
            }
        }
    }

}
