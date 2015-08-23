<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Route;

/**
 * Class RouteMatcher
 * @package Anonym\Components\Route
 */
class RouteMatcher implements RouteMatcherInterface
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

        if ($this->isUrlEqual() || $this->regexChecker()) {
            return true;
        }else{
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





}
