<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Guidance\WebapiLogging\Model\ResourceModel\Log\CollectionFactory as LogCollectionFactory;

class LogDataProvider extends AbstractDataProvider
{
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        LogCollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create()
            ->addFieldToSelect('log_id');
    }
}
