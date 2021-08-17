<?php

namespace PParser\Core;

/**
 * Класс контейнер зависимостей
 */
class Di
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value): Di
    {
        $this->container[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key): mixed
    {
        return $this->has($key);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function has($key): mixed
    {
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }
}

?>