<?php
/**
 * List routes
 */

$this->router->add('home', '/', 'HomeController:index');
$this->router->add('loading', '/loading', 'HomeController:loading','POST');