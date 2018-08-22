<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\Formatter;

use Monolog\Formatter\FormatterInterface;

class PrivateDataFilter implements FormatterInterface
{
    use SimpleBatch;

    const MASK = '****';

    protected $maskPatterns = [
        '/"password"\s*\:\s*"([^"]*)"/',    // integration token password
        '/"(\w{32})"/',                     // auth token
        '/"(\d{12})\d{4}"/',                // credit card number
        '/"cc_cid"\s*\:\s*"(\d+)"/',        // cvv
        '/Authorization\: Bearer (\w+)/',   // api key mask
    ];

    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return mixed The formatted record
     */
    public function format(array $record)
    {
        return preg_replace_callback($this->maskPatterns, function ($matches) {
            return isset($matches[1])
                ? str_replace($matches[1], self::MASK, $matches[0])
                : self::MASK;
        }, $record['message']);
    }
}
