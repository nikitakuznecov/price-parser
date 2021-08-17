<?php

namespace PParser\Controller;
use PParser\Core\Di;

abstract class AbstractController
{
    protected $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
        $this->initVars();
    }
    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->di->get($key);
    }

    /**
     * @return Controller
     */
    public function initVars()
    {
        $vars = array_keys(get_object_vars($this));

        foreach ($vars as $var) {
            if ($this->di->has($var)) {
                $this->{$var} = $this->di->get($var);
            }
        }

        return $this;
    }
}