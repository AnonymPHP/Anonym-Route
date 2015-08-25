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
     * the parameters of route
     *
     * @var string
     */
    private $parameters;
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

        if (preg_replace_callback($this->getRegexSchema(), [$this, 'resolvePregCallback'], $this->getMatchUrl())) {
            var_dump($this->parameters);

        }

        /*
        if (preg_match_all($this->regexSchema, $this->getMatchUrl(), $matches)) {
            list($orjinals, $cleaned) = $matches;
            $requestEx = explode(' ', $this->getRequestedUrl());
            $matchEx = explode(' ', $this->getMatchUrl());
            $replaced = $this->findAndReplaceParameters($orjinals, $cleaned, $requestEx, $matchEx);

            if (false !== $replaced) {
                ParameterBag::setParameters($replaced);
                return true;
            }
        }
        */
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
        $this->parameters[] = isset($requestEx[$key]) ? $requestEx[$key] : false;

    }

    /**
     * find and replace parameters
     *
     * @param array $orjinal
     * @param array $cleaned
     * @param array $requestedEx
     * @return array|bool
     */
    private function findAndReplaceParameters(array $orjinal, array $cleaned, array $requestedEx, array $matchEx)
    {
        $replaced = [];
        return $replaced;
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
