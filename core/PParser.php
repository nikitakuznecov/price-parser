<?php

namespace PParser\Core;

class PParser
{
    /**
     *  DI контейнер
     */
    private $di;

    public $router;

    /**
     *  Конструктор принимает di контейнер
     */
    public function __construct($di) {

        $this->di = $di;
        $this->router = $this->di->get('Router');

    }

    /**
     *  Единая точка входа - главный метод Run
     */
    public function run(){

        try {

            setlocale (LC_ALL, "ru_RU.UTF-8");

            require_once(Helper::getInstance()->replacePath( '/config/Route.php' ));

            $routerDispatch = $this->router->dispatch(Helper::getInstance()->getMethod(), Helper::getInstance()->getPathUrl());

            if ($routerDispatch == null) {

                $routerDispatch = new DispatchedRoute('HomeController:index');

            }

            list($class, $action) = explode(':', $routerDispatch->getController(), 2);

            $controller = 'PParser\\Controller\\' . $class;
            $parameters = $routerDispatch->getParameters();
            call_user_func_array(array(new $controller($this->di),$action), $parameters);

        }catch (\Exception $e){

            print($e->getMessage());
            exit;
        }
    }
}