<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\Formatter;

use Monolog\Formatter\FormatterInterface;

class Chain implements FormatterInterface
{
    use SimpleBatch;

    /**
     * @var FormatterInterface[]
     */
    protected $formatters = [];

    public function __construct(array $formatters)
    {
        foreach ($formatters as $formatter) {
            if (!$formatter instanceof FormatterInterface) {
                throw new \InvalidArgumentException(get_class($formatter) . ' should implement FormatterInterface');
            }
            $this->formatters[] = $formatter;
        }
    }

    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return mixed The formatted record
     */
    public function format(array $record)
    {
        foreach ($this->formatters as $formatter) {
            $record['message'] = $formatter->format($record);
        }
        return $record['message'];
    }
}
