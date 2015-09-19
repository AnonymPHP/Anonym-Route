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


trait ModelDispatcher
{

    /**
     * the namespace of models
     *
     * @var string
     */
    private $namespace = 'Anonym\Models';


    /**
     * the instance of model
     *
     * @var Object
     */
    protected $model;


    /**
     * create and return model instance
     *
     * @param string $name
     * @param null $namespace
     * @return mixed
     */
    public function model($name = '', $namespace = null)
    {
        if (null === $name) {
            $namespace = $this->namespace;
        }

        $namespace = $this->resolveNamespace($namespace);
        $model = $this->model = $this->createModelInstance($namespace, $name);

        return $model;
    }

    /**
     * create a model instance
     *
     * @param string $namespace
     * @param string $name
     * @return mixed
     */
    private function createModelInstance($namespace = '', $name = '')
    {
        $class = $namespace . $name;
        return new $class;
    }

    /**
     * resolve the namespace
     *
     * @param string $namespace
     * @return string
     */
    private function resolveNamespace($namespace = '')
    {
        if (substr($namespace, -1) !== '\\') {
            $namespace .= '\\';
        }

        return $namespace;
    }
}