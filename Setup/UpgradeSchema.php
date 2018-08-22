<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Setup;

use Guidance\Setup\Setup\VersionedSchemaSetup;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    use VersionedSchemaSetup;

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->processVersions($setup, $context);
    }

    /**
     * @param SchemaSetupInterface $this->setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    private function version_1_1_0()
    {
        $table = $this->conn
            ->newTable(
                $this->setup->getTable('webapi_log')
            )
            ->addColumn(
                'log_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'identity' => true,
                    'primary' => true
                ],
                'Log ID'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Log Time'
            )
            ->addColumn(
                'method',
                Table::TYPE_TEXT,
                '16',
                [],
                'HTTP method'
            )
            ->addColumn(
                'response_code',
                Table::TYPE_INTEGER,
                3,
                [],
                'Response code'
            )
            ->addColumn(
                'url',
                Table::TYPE_TEXT,
                '255',
                [],
                'Request URL'
            )
            ->addColumn(
                'request',
                Table::TYPE_TEXT,
                '16M',
                [],
                'Request body'
            )
            ->addColumn(
                'response',
                Table::TYPE_TEXT,
                '16M',
                [],
                'Response body'
            )
            ->addColumn(
                'additional',
                Table::TYPE_TEXT,
                '16M',
                [],
                'Additional'
            )
            ->addIndex(
                $this->setup->getIdxName(
                    'webapi_log',
                    ['created_at'],
                    AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['created_at'],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            )
            ->setComment('Web API Log Table');

        $this->conn->createTable($table);
    }
}
