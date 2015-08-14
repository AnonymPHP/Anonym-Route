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
     */
    public function __construct($requestedUrl = '', $matchUrl = '')
    {
        $this->setMatchUrl($matchUrl);
        $this->setRequestedUrl($requestedUrl);
    }

    /**
     * Eşleşmeyi yapar
     *
     * @param string $matchUrl
     * @return bool
     */
    public function match($matchUrl = '')
    {
        $this->setMatchUrl($matchUrl);

        

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
     * @param string $matchUrl
     * @return RouteMatcher
     */
    public function setMatchUrl($matchUrl)
    {
        $this->matchUrl = $matchUrl;
        return $this;
    }



}
