<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Cron;

use Guidance\WebapiLogging\Model\ResourceModel\Log;
use Magento\Framework\App\Config\ScopeConfigInterface;

class DbLogCleaner
{
    const CONFIG_PATH_SAVE_LAST_DAYS = 'system/webapi_log/lifetime';

    protected $logResource;
    protected $config;

    public function __construct(Log $logResource, ScopeConfigInterface $config)
    {
        $this->logResource = $logResource;
        $this->config = $config;
    }

    public function execute()
    {
        $saveLastDays = $this->config->getValue(self::CONFIG_PATH_SAVE_LAST_DAYS);

        if (!$saveLastDays) {
            return;
        }
        $this->logResource->purge(new \DateInterval('P' . (int)$saveLastDays . 'D'));
    }
}
