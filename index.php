<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */

include 'vendor/autoload.php';

$matcher = new \Anonym\Components\Route\Matchers\NewMatcher('/{test}/', '/asdasd');
$matcher->match();
