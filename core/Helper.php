<?php

namespace PParser\Core;

/**
 * Класс помощник тут собраны
 * часто используемые методы
 */
class Helper extends Singleton
{
    /**
     * @return array|string|string[]
     */
    public function replacePath($path)
    {

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

            $path = str_replace('/', '\\'.'\\', $_SERVER['DOCUMENT_ROOT'].$path);

        } else {

            $path = $_SERVER['DOCUMENT_ROOT'].$path;
        }

        return $path;

    }

    /**
     * @return bool
     */
    public function isPost()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return bool|string
     */
    public function getPathUrl()
    {
        $pathUrl = $_SERVER['REQUEST_URI'];

        if($position = strpos($pathUrl, '?'))
        {
            $pathUrl = substr($pathUrl, 0, $position);
        }

        return $pathUrl;
    }
}