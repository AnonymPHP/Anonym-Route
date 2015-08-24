<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */

include 'vendor/autoload.php';

$matcher  = new \Anonym\Components\Route\Matchers\NewMatcher('/asdasd/asdasd', '/{test}/{param}');
$matcher->match();