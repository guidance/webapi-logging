<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\Logger;

use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;
use Monolog\Handler\AbstractHandler;
use Guidance\WebapiLogging\Model\LogFactory;

/**
 * Monolog Handler for writing log entries to a database table
 */
class DbHandler extends AbstractHandler
{
    protected $logFactory;

    private $sessionToLog = [];

    public function __construct(LogFactory $logFactory, FormatterInterface $formatter)
    {
        parent::__construct(Logger::DEBUG, true);

        $this->logFactory = $logFactory;
        $this->setFormatter($formatter);
    }

    public function handle(array $record)
    {
        if (!$this->isHandling($record)) {
            return false;
        }
        $record['formatted'] = $this->getFormatter()->format($record);
        $this->write($record);

        return false === $this->bubble;
    }

    /**
     * Writes the log to the database by utilizing the Log model
     *
     * @param $record array
     * @return void
     */
    public function write(array $record)
    {
        $log = $this->logFactory->create();

        if ($record['context']['session'] && isset($this->sessionToLog[$record['context']['session']])) {
            $log->load($this->sessionToLog[$record['context']['session']]);
        }
        if (isset($record['context']['type'])) {
            switch ($record['context']['type']) {
                case \Guidance\WebapiLogging\Plugin\Controller\Logger::MESSAGE_RESPONSE:
                    if ($log->getResponse()) {
                        $log->unsLogId();
                    }
                    $log->setResponse($record['formatted']);

                    if (preg_match('/HTTP\/.*\s+(\d{3})/', $record['formatted'], $m)) {
                        $log->setResponseCode($m[1]);
                    }
                    break;

                case \Guidance\WebapiLogging\Plugin\Controller\Logger::MESSAGE_REQUEST:
                    if ($log->getRequest()) {
                        $log->unsLogId();
                    }
                    $log->setRequest($record['formatted']);

                    if (preg_match('/(\w+)\s+([^\s]+)\s+HTTP\//', $record['formatted'], $m)) {
                        $log->setMethod($m[1]);
                        $log->setUrl($m[2]);
                    }
                    break;

                default:
                    if ($log->getAdditional()) {
                        $log->unsLogId();
                    }
                    $log->setAdditional($record['formatted']);

            }
        }
        $log->save();

        if (isset($record['context']['session'])) {
            $this->sessionToLog[$record['context']['session']] = $log->getId();
        }
    }
}
