<?php

namespace App\Models;


class Log
{
    protected static $instance;
    private static $fileName = 'log.txt';
    private static $errorLevels = [
        NONE=> 'NONE',
        INFO=>'INFO',
        WARN=>'WARN',
        CRITICAL=>'CRITICAL',
        ALL=>'ALL'
    ];

    public static function write($message, $level)
    {
        if($level === ERROR_LOG_LEVEL || ERROR_LOG_LEVEL === ALL) {
            self::writeToFile($message, $level);
        }
    }

    private static function writeToFile($message, $level)
    {
        date_default_timezone_set('Europe/Stockholm');
        $levelName = self::$errorLevels[$level];
        $line = sprintf("%s\t%s\t%s%s", $levelName, date('Y-m-d h:i:s', time()), $message, PHP_EOL);
        $dirPath = realpath(dirname(dirname(__FILE__)));
        $filePath = sprintf("%s/%s/%s", $dirPath, 'web', self::$fileName);

        try {
            return file_put_contents($filePath, $line, FILE_APPEND | LOCK_EX);
        } catch (exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
