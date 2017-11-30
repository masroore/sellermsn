<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 20/10/16
 * Time: 1:23 PM
 */

namespace app\service {

    use Psr\Log\LogLevel;


    class Logger
    {
        public static $logger = null;

        public static function logger()
        {
            if (is_null(self::$logger)) {
                self::$logger = new \Katzgrau\KLogger\Logger(BUILD_PATH . '/logs', LogLevel::DEBUG, array(
                    'extension' => 'log', // changes the log file extension
                ));
            }
            return self::$logger;
        }

        public static function log($level, $message, array $context = array())
        {
            self::logger()->log($level, $message, $context);
        }

        public static function info($message, array $context = array())
        {
            self::logger()->info($message, $context);
        }

        public static function error($message, array $context = array())
        {
            self::logger()->error($message, $context);
        }

        public static function debug($message, array $context = array())
        {
            self::logger()->debug($message, $context);
        }

        public static function warning($message, array $context = array())
        {
            self::logger()->warning($message, $context);
        }

    }


}

