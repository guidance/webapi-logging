<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Plugin\Controller;

use Guidance\WebapiLogging\Api\RequestFilterInterface;
use Magento\Framework\App;
use Magento\Framework\WebapiLogging;
use Psr\Log\LoggerInterface;

class Logger
{
    const MESSAGE_REQUEST = 'request';
    const MESSAGE_RESPONSE = 'response';

    protected $logger;
    protected $request;
    protected $requestFilter;
    protected $shouldLog = true;
    protected $sessionId;

    public function __construct(WebapiLogging\Request $request, LoggerInterface $logger, RequestFilterInterface $requestFilter = null)
    {
        $this->logger = $logger;
        $this->request = $request;
        $this->shouldLog = $requestFilter ? $requestFilter->accept($request) : true;
        $this->sessionId = uniqid();
    }

    public function beforeDispatch(App\FrontControllerInterface $controller, App\RequestInterface $request)
    {
        if ($this->shouldLog) {
            $this->logger->debug($this->request, ['session' => $this->sessionId, 'type' => self::MESSAGE_REQUEST]);
        }
    }

    public function afterDispatch(App\FrontControllerInterface $controller, WebapiLogging\Response $response)
    {
        if ($this->shouldLog) {
            if ($response instanceof WebapiLogging\Rest\Response && $response->isException()) {
                foreach ($response->getException() as $e) {
                    $this->logger->debug((string)$e, ['session' => $this->sessionId, 'type' => self::MESSAGE_RESPONSE]);
                }
            } else {
                $this->logger->debug($response, ['session' => $this->sessionId, 'type' => self::MESSAGE_RESPONSE]);
            }
        }
        return $response;
    }
}
