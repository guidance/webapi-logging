<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Registry;

class Log extends Template
{
    protected $registry;

    public function __construct(Template\Context $context, Registry $registry, array $data = [])
    {
        parent::__construct($context, $data);

        $this->registry = $registry;
    }

    /**
     * @return \Guidance\WebapiLogging\Model\Log
     */
    public function getLog()
    {
        $log = $this->registry->registry('log');

        if (!$log instanceof \Guidance\WebapiLogging\Model\Log) {
            throw new \DomainException('Log is not loaded');
        }
        return $log;
    }

    public function formatHeader($header)
    {
        $header = $this->escapeHtml($header);
        $header = preg_replace('/^[\w\-]+\:/m', '<span class="json-property">$0</span>', $header);
        $header = preg_replace('/^(POST|GET|PUT|DELETE|HEAD|OPTIONS)/', '<span class="json-literal">$0</span>', $header);
        $header = preg_replace('|https+\://[^\s]+|', '<a href="$0" class="json-url">$0</a>', $header);

        return $header;
    }
}
