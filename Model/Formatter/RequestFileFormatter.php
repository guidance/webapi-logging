<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\Formatter;

use Guidance\WebapiLogging\Plugin\Controller\Logger;
use Monolog\Formatter\FormatterInterface;

class RequestFileFormatter implements FormatterInterface
{
    use SimpleBatch;

    public function format(array $record)
    {
        $formatted = $record['message'];

        switch ($record['context']['type']) {
            case Logger::MESSAGE_REQUEST:
                return "======================================================\n{$formatted}\n";

            default:
                return "\n$formatted\n";
        }
    }
}
