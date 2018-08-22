<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Controller\Adminhtml\Webapilog;

use Guidance\WebapiLogging\Model\LogFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;

class View extends \Magento\Backend\App\AbstractAction
{
    protected $logFactory;
    protected $registry;

    public function __construct(Action\Context $context, LogFactory $logFactory, Registry $registry)
    {
        parent::__construct($context);

        $this->logFactory = $logFactory;
        $this->registry = $registry;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $log = $this->logFactory->create()->load($id);

        if ($log->isObjectNew()) {
            return $this->resultFactory
                ->create(ResultFactory::TYPE_REDIRECT)
                ->setRefererOrBaseUrl();
        }
        $this->registry->register('log', $log);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('REST API Log'));

        return $resultPage;
    }
}
