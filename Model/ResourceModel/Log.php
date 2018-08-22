<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Log
 */
class Log extends AbstractDb
{
    /**
     * Define main table
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('webapi_log', 'log_id');
    }

    public function purge(\DateInterval $saveLast)
    {
        $margin = new \DateTime;
        $margin->sub($saveLast);

        $this->getConnection()
            ->delete($this->getMainTable(), ['created_at < ?' => $margin->format('Y-m-d H:i:s')]);
    }
}
