<?php
/**
 * This file belongs to the AnoynmFramework
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 * Thanks for using
 */

namespace Anonym\Components\Route\Matchers;


use Anonym\Components\Route\RouteMatcher;

/**
 * Class ExplodeMatcher
 * @package Anonym\Components\Route\Matchers
 */
class ExplodeMatcher extends RouteMatcher implements MatcherInterface
{


    private $explodeWith = ' ';
    /**
     *make the match
     *
     * @return bool
     */
    public function match()
    {


    }

    /**
     * @return string
     */
    public function getExplodeWith()
    {
        return $this->explodeWith;
    }

    /**
     * @param string $explodeWith
     * @return ExplodeMatcher
     */
    public function setExplodeWith($explodeWith)
    {
        $this->explodeWith = $explodeWith;
        return $this;
    }


}
