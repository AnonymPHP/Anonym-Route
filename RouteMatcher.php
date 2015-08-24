<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Route;

use Anonym\Components\Route\Matchers\MatcherInterface;
use Anonym\Components\Route\Matchers\NewMatcher;

/**
 * Class RouteMatcher
 * @package Anonym\Components\Route
 */
class RouteMatcher implements RouteMatcherInterface, MatcherInterface
{

    /**
     * Parametre adlarını depolar
     *
     * @var array
     */
    protected $parameters = [];
    /**
     * Filtreleri toplar
     *
     * @var array
     */
    protected $filters;

    /**
     * Çağrılan url i getirir
     *
     * @var string
     */
    protected $requestedUrl;

    /**
     * Eşleştirilecek url i tutar
     *
     * @var string
     */
    private $matchUrl;


    /**
     * the instance of matcher
     *
     * @var MatcherInterface
     */
    private $matcher;

    /**
     * Eşleştirilecek ve eşleşmesi gerek url i ayarlar
     *
     * @param string $requestedUrl
     * @param string $matchUrl
     * @param array $filters
     */
    public function __construct($requestedUrl = '', $matchUrl = '', $filters = [])
    {
        $this->setMatchUrl($matchUrl);
        $this->setRequestedUrl($requestedUrl);
        $this->setFilters($filters);
        $this->setMatcher(new NewMatcher($requestedUrl, $matchUrl, $filters));

    }

    /**
     * Eşleşmeyi yapar
     *
     * @param string $matchUrl
     * @return bool
     */
    public function match($matchUrl = null)
    {
        if (null !== $matchUrl) {
            $this->setMatchUrl($matchUrl);
        }

        if ($this->isUrlEqual() || $this->getMatcher()->match()) {
            return true;
        } else {
            return false;
        }

    }


    /**
     *
     * Urller aynı ise direk döndürüyor
     *
     * @return bool
     */
    private function isUrlEqual()
    {

        if ($this->getMatchUrl() === $this->getRequestedUrl()) {
            return true;
        }

    }

    /**
     * @return string
     */
    public function getRequestedUrl()
    {
        return $this->requestedUrl;
    }


    /**
     * @param string $requestedUrl
     * @return RouteMatcher
     */
    public function setRequestedUrl($requestedUrl)
    {
        $requestedUrl = trim(str_replace('/', ' ', $requestedUrl));
        $this->requestedUrl = $requestedUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getMatchUrl()
    {
        return $this->matchUrl;
    }

    /**
     * Eşleştirilecek url i ayarlar
     *
     * @param string $matchUrl
     * @return RouteMatcher
     */
    public function setMatchUrl($matchUrl)
    {
        $matchUrl = trim(str_replace('/', ' ', $matchUrl));
        $this->matchUrl = $matchUrl;
        return $this;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     * @return RouteMatcher
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * $name ile girilen filter 'ı arar
     *
     * @param string $name
     * @return mixed
     */
    public function getFilter($name = '')
    {
        return $this->filters[$name];
    }


    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return RouteMatcher
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return MatcherInterface
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param MatcherInterface $matcher
     * @return RouteMatcher
     */
    public function setMatcher(MatcherInterface $matcher)
    {
        $this->matcher = $matcher;
        return $this;
    }


}

