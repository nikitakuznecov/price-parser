<?php
/**
 * List routes
 */

$this->router->add('home', '/', 'HomeController:index');
$this->router->add('loading', '/loading', 'HomeController:loading','POST');
$this->router->add('lastThree', '/lastThree', 'HomeController:lastThree','POST');
$this->router->add('middlePrice', '/middlePrice', 'HomeController:middlePrice','POST');
$this->router->add('periodPrice', '/periodPrice', 'HomeController:periodPrice','POST');
$this->router->add('reset', '/reset', 'HomeController:reset','POST');