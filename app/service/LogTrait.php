<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 20/10/16
 * Time: 1:23 PM
 */

namespace app\service {

    use Psr\Log\LogLevel;

    trait LogTrait
    {

        public $logger = null;

        public $showLog = true;

        public function logger()
        {
            if (is_null($this->logger)) {
                $this->logger = new \Katzgrau\KLogger\Logger(BUILD_PATH . '/logs', LogLevel::DEBUG, array(
                    'extension' => 'log', // changes the log file extension
                ));
            }
            return $this->logger;
        }

        public function log($level, $message, array $context = array())
        {
            if (!$this->showLog) return;
            $this->logger()->log($level, $message, $context);
        }

        public function info($message, array $context = array())
        {
            if (!$this->showLog) return;
            $this->logger()->info($message, $context);
        }

        public function error($message, array $context = array())
        {
            if (!$this->showLog) return;
            $this->logger()->error($message, $context);
        }

        public function debug($message, array $context = array())
        {
            if (!$this->showLog) return;
            $this->logger()->debug($message, $context);
        }

        public function warning($message, array $context = array())
        {
            if (!$this->showLog) return;
            $this->logger()->warning($message, $context);
        }

    }

}

