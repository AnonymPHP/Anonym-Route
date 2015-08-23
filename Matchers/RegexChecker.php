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
use Anonym\Components\Route\ParameterBag;

class RegexChecker extends RouteMatcher
{

    /**
     *Regex kontrolu yapar
     *
     * @return bool
     */
    public function regexChecker()
    {


        $regex = $this->getRegex($this->getMatchUrl());


        if ($regex !== ' ') {
            if (preg_match("@" . ltrim($regex) . "@si", $this->getRequestedUrl(), $matches)) {
                unset($matches[0]);
                ParameterBag::setParameters($matches);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * Regex i d�nd�r�r
     *
     * @param string $url
     * @return mixed
     */
    private function getRegex($url)
    {

        return preg_replace_callback("/:(\w.*)/", [$this, 'substituteFilter'], $url);
    }

    /**
     * @param array $matches
     * @return string
     */
    private function substituteFilter(array $matches = [])
    {
        $this->parameters[] = $matches[1];
        return isset($this->collector->filter[$matches[1]]) ? "({$this->getFilter($matches[1])})" : "([\w-%]+)";
    }
}