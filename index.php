<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */

include 'vendor/autoload.php';
use Anonym\Components\Route\RouteCollector;
use Anonym\Components\Route\Router;
use Anonym\Components\HttpClient\Request;
$collector = new RouteCollector();
$collector->get('/', [
    '_controller' =>  'Test::a'
]);

$route = new Router(new Request());
$route->run();
