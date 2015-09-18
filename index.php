<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */

include 'vendor/autoload.php';

$route = new \Anonym\Components\Route\Router(new \Anonym\Components\HttpClient\Request());

$matcher = new \Anonym\Components\Route\Matchers\NewMatcher('/aaaa', '{test}', \Anonym\Components\Route\FilterBag::getFilters());

var_dump($matcher->match());