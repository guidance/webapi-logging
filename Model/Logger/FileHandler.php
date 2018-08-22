<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\Logger;

use Magento\Framework\Filesystem\DriverInterface;
use Monolog\Formatter\FormatterInterface;

class FileHandler extends \Magento\Framework\Logger\Handler\Base
{
    protected $fileName = '/var/log/webapi.log';

    public function __construct(DriverInterface $filesystem, FormatterInterface $formatter, string $filePath = null)
    {
        parent::__construct($filesystem, $filePath);

        $this->setFormatter($formatter);
    }
}
