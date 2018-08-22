<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Log
 *
 * @method string getCreatedAt() getCreatedAt()
 * @method string getRequest() getRequest()
 * @method string getResult() getResult()
 * @method string getAdditional() getAdditional()
 */
class Log extends AbstractModel
{
    /**
     * Object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Log::class);
    }

    public function getRequestHeader()
    {
        list ($header, $body) = $this->splitBody($this->getRequest());

        return $header;
    }

    public function getRequestBody()
    {
        list ($header, $body) = $this->splitBody($this->getRequest());

        return $body;
    }

    public function getResponseHeader()
    {
        list ($header, $body) = $this->splitBody($this->getResponse());

        return $header;
    }

    public function getResponseBody()
    {
        list ($header, $body) = $this->splitBody($this->getResponse());

        return $body;
    }

    public function isRequestBodyJson()
    {
        return $this->isJson($this->getRequestBody());
    }

    public function isResponseBodyJson()
    {
        return $this->isJson($this->getResponseBody());
    }

    protected function isJson($text)
    {
        return $text === 'false' || false !== @json_decode($text);
    }

    protected function splitBody($body)
    {
        $part = explode("\r\n\r\n", $body, 2);

        if (!isset($part[1])) {
            $part[1] = null;
        }
        return $part;
    }
}
