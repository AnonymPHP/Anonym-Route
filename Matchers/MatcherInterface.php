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

/**
 * Interface MatcherInterface
 * @package Anonym\Components\Route\Matchers
 */
interface MatcherInterface
{

    /**
     *make the match
     *
     * @param string|null url
     * @return bool
     */
    public function match($url = null);

}
