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
     * Eþleþtirilecek ve eþleþmesi gerek url i ayarlar
     *
     * @param string $requestedUrl
     * @param string $matchUrl
     * @param array $filters
     */
    public function __construct($requestedUrl = '', $matchUrl = '', $filters = [])
    {
        parent::__construct($requestedUrl, $matchUrl, $filters);
    }

    /**
     *Regex kontrolu yapar
     *
     * @return bool
     */
    public function match()
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
     * Regex i döndürür
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