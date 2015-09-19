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


use Anonym\Components\Route\FilterMatchException;
use Anonym\Components\Route\ParameterBag;
use Anonym\Components\Route\RouteMatcher;

/**
 * Class ExplodeMatcher
 * @package Anonym\Components\Route\Matchers
 */
class NewMatcher extends RouteMatcher implements MatcherInterface
{


    /**
     * the schema of regex
     *
     * @var string
     */
    private $regexSchema = '@{(.*?)}@si';

    /**
     * url i ayarlar
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
     *make the match
     *
     * @param string|null $url
     * @return bool
     */
    public function match($url = null)
    {
        $match = parent::match($url);

        $find = $this->replaceParameters();

        if (false !== $find || true === $match) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * find and replace parameters
     *
     * @return bool
     */
    private function replaceParameters()
    {

        if (preg_match($this->regexSchema, $this->getMatchUrl())) {

            preg_replace_callback($this->getRegexSchema(), [$this, 'resolvePregCallback'], $this->getMatchUrl());

            $resolve = $this->resolveParameters($this->getParameters());


            // something went wrong!
            if (false === $resolve) {
                return false;
            }

            ParameterBag::setParameters($this->getParameters());
        } elseif ($this->getMatchUrl() !== $this->getRequestedUrl()) {
            return false;
        }

        return true;
    }

    /**
     * resolve the preg callback
     *
     * @param array $finded
     * @return bool|string
     */
    private function resolvePregCallback($finded)
    {

        $matchEx = explode(' ', $this->getMatchUrl());
        $requestEx = explode(' ', $this->getRequestedUrl());
        $key = array_search($finded[0], $matchEx);
        $cln = $finded[1];

        if (strstr($cln, ':')) {
            list($cln, $filter) = explode(':', $cln);
        }

        if (!strstr($cln, '?')) {
            $add = isset($requestEx[$key]) && $requestEx[$key] !== '' ? $requestEx[$key] : false;
        } else {
            $add = isset($requestEx[$key]) ? $requestEx[$key] : null;
        }

        // we gonna do run filter  now
        if(!$this->runFilter(isset($filter) ? $filter : $cln, $add)){
            throw new FilterMatchException('Your filter do not match');
        }

        $this->parameters[$cln] = $add;
    }

    /**
     * execute a filter
     *
     * @param string $filter
     * @param string $parameter
     * @return bool|int
     */
    private function runFilter($filter, $parameter){
         if(!strstr($filter, '(') && !strstr($filter, ')')){
               if(!$filter = $this->getFilter($filter)){
                   return false;
               }
         }

        return preg_match('@'.$filter.'@si', $parameter) ?: false;
    }

    /**
     * resolve the parameters of route
     *
     * @param array $parameters
     * @return bool
     */
    private function resolveParameters(array $parameters)
    {


        foreach ($parameters as $parameter) {
            if (false === $parameter) {
                return false;
            }
        }

        return true;
    }


    /**
     * @return string
     */
    public function getRegexSchema()
    {
        return $this->regexSchema;
    }

    /**
     * @param string $regexSchema
     * @return NewMatcher
     */
    public function setRegexSchema($regexSchema)
    {
        $this->regexSchema = $regexSchema;
        return $this;
    }


}
