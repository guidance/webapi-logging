<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Controller\Adminhtml\Webapilog;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\AbstractAction
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('REST API Log'));

        return $resultPage;
    }
}
