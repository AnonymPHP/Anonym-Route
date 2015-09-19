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
use Anonym\Components\Security\Validation;

/**
 * the parent class of controllers
 *
 * Class Controller
 * @package Anonym\Components\Route
 */
abstract class Controller
{
    use Middleware, ModelDispatcher;

    /**
     * repository of parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * register the parameters
     *
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters = [])
    {
        $this->parameters = $parameters;
        return $this;
    }


    /**
     * validate the form
     *
     * @param Request $request
     * @param array $rules
     * @param array $filters
     */
    public function validate(Request $request, array $rules = [],array $filters = [])
    {
        $all = $request->all();

        return $request->getValidation()->make($all, $rules, $filters);
    }
}
