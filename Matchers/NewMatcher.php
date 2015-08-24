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
class NewMatcher extends RouteMatcher implements MatcherInterface
{


    /**
     * the schema of regex
     *
     * @var string
     */
    private $regexSchema = '/\{.*?\?\}/';

    /**
     * E�le�tirilecek ve e�le�mesi gerek url i ayarlar
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
        $replace = $this->replaceParameters();
        
    }
    
    private function replaceParameters()
    {
        
    }

}
