<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\ResourceModel\Log;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Guidance\WebapiLogging\Model\Log::class, \Guidance\WebapiLogging\Model\ResourceModel\Log::class);
    }

    public function addFieldToSelect($field, $alias = null)
    {
        switch ($field) {
            case 'request_short':
                return $this->addExpressionFieldToSelect($field, 'SUBSTRING(request FROM 1 for 140)', []);

            case 'response_short':
                return $this->addExpressionFieldToSelect($field, 'SUBSTRING(response FROM 1 for 140)', []);
        }
        return parent::addFieldToSelect($field, $alias);
    }
}
