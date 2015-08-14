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
class RouteMatcher
{

    /**
     * Filtreleri toplar
     *
     * @var array
     */
    private $filters;

    /**
     * Çağrılan url i getirir
     *
     * @var string
     */
    private $requestedUrl;

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
     *Regex kontrolu yapar
     *
     * @return bool
     */
    private function regexChecker()
    {


        $regex = $this->getRegex($this->getMatchUrl());


        if ($regex !== ' ') {
            if (preg_match("@" . ltrim($regex) . "@si", $this->getRequestedUrl(), $matches)) {
                unset($matches[0]);
                return true;
            } else {
                return false;
            }
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
         return isset($this->collector->filter[$matches[1]]) ? "({$this->getFilter($matches[1])})" : "([\w-%]+)";
     }

}
