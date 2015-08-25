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


    protected $model;

    public function model($name = '', $namespace = null)
    {
        if (null === $name) {
            $namespace = $this->namespace;
        }

        $namespace = $this->resolveNamespace($namespace);
    }

}