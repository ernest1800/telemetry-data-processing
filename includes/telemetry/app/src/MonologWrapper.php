<?php
/**
 * MonologWrapper
 * Wrapper for Logging using monolog
 *
 * @author P2508450
 */

namespace Telemetry;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MonologWrapper
{
    private $logger;
    public function __construct()
    {
        $this->logger = new Logger('telemetry-app-log');
        $this->logger->pushHandler(new StreamHandler(LOG_FILE_PATH, Logger::DEBUG));
    }

    public function __destruct()
    {
    }

    /**
     * stores log using monolog
     * @param $message
     */
    public function storeLog($message)
    {
        $this->logger->info($message);
    }
}
