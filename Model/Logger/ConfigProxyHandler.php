<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2019 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\Logger;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;

class ConfigProxyHandler implements HandlerInterface
{
    protected $subject;
    protected $enabled;

    public function __construct(HandlerInterface $subject, string $configPath, ScopeConfigInterface $config)
    {
        $this->subject = $subject;
        $this->enabled = $config->isSetFlag($configPath);
    }

    public function isHandling(array $record)
    {
        return $this->enabled && $this->subject->isHandling($record);
    }

    public function handle(array $record)
    {
        return $this->enabled && $this->subject->handle($record);
    }

    public function handleBatch(array $records)
    {
        return $this->enabled && $this->subject->handleBatch($records);
    }

    public function pushProcessor($callback)
    {
        return $this->subject->pushProcessor($callback);
    }

    public function popProcessor()
    {
        return $this->subject->popProcessor();
    }

    public function setFormatter(FormatterInterface $formatter)
    {
        return $this->subject->setFormatter($formatter);
    }

    public function getFormatter()
    {
        return $this->subject->getFormatter();
    }
}
