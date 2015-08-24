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
     * @return bool
     */
    public function match()
    {
        $find = $this->replaceParameters();

        if (false !== $find) {

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

        if (preg_match_all($this->regexSchema, $this->getMatchUrl(), $matches)) {
            list($orjinals, $cleaned) = $matches;
            $requestEx = explode(' ', $this->getRequestedUrl());
            $replaced = $this->findAndReplaceParameters($orjinals, $cleaned, $requestEx);

            if (false !== $replaced) {
                ParameterBag::setParameters($replaced);
            }
        }
    }

    /**
     * find and replace parameters
     *
     * @param array $orjinal
     * @param array $cleaned
     * @param array $requestedEx
     * @return array|bool
     */
    private function findAndReplaceParameters(array $orjinal, array $cleaned, array $requestedEx)
    {

        $replaced = [];

        for ($i = 0; $i < count($orjinal); $i++) {
            $orj = $orjinal[$i];
            $cln = $cleaned[$i];
            $rex = isset($requestedEx[$i]) ? $requestedEx[$i] : null;

            $fullcln = str_replace(['?', '!'], '', $cln);
            if($filter = $this->getFilter($fullcln))
            {
                if(!preg_match('@'. $filter. '@si', $rex))
                {
                    return false;
                }
            }

            if (strpos($cln, '!')) {
                if (null === $rex) {
                    return false;
                } else {
                    $replaced[] = $rex;
                }
            } // check the parameter
            elseif (strpos($cln, '?')) {
                if (null !== $rex) {
                    $replaced[] = $rex;
                }
            } else {
                $replaced[] = $rex;
            }
        }
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
