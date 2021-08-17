<?php

namespace PParser\Core;

/**
 * Класс логер, основная задача упросить работу
 * с логом сообщений
 */
class Logger extends Singleton
{
    /**
     * Ресурс указателя файла файла журнала.
     */
    private $fileHandle;


    /**
     * Поскольку конструктор Одиночки вызывается только один раз, постоянно
     * открыт всего лишь один файловый ресурс.
     */
    protected function __construct()
    {
        $path = Helper::getInstance()->replacePath('/cache/log.txt');

        $this->fileHandle = fopen($path, 'a');
    }

    /**
     * Пишем запись в журнале в открытый файловый ресурс.
     */
    public function writeLog(string $message): void
    {
        $date = date('Y-m-d');
        fwrite($this->fileHandle, "$date: $message\n");
    }

    /**
     * Просто удобный ярлык для уменьшения объёма кода, необходимого для
     * регистрации сообщений из клиентского кода.
     */
    public static function log(string $message): void
    {
        $logger = static::getInstance();
        $logger->writeLog($message);
    }
}