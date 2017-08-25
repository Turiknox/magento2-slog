<?php
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\SLog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('slog_visitor')) {
            $visitorsTable = $installer->getConnection()
                ->newTable($installer->getTable('slog_visitor'))
                ->addColumn(
                    'entity_id',
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                ->addColumn(
                    'visitor_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true],
                    'Visitor ID'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true],
                    'Customer ID'
                )
                ->addColumn(
                    'customer_email',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Customer Email'
                )
                ->addColumn(
                    'customer_ip',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Customer IP'
                )
                ->addColumn(
                    'last_visit_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false],
                    'Last Visit Time'
                )
                ->addIndex(
                    $installer->getIdxName(
                        'slog_visitor',
                        ['entity_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                );
            $installer->getConnection()->createTable($visitorsTable);
        }

        if (!$installer->tableExists('slog_customer_product_viewed')) {
            $productsTable = $installer->getConnection()
                ->newTable($installer->getTable('slog_customer_product_viewed'))
                ->addColumn(
                    'entity_id',
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                ->addColumn(
                    'slog_visitor_id',
                    Table::TYPE_BIGINT,
                    null,
                    ['unsigned' => true],
                    'Visitor ID'
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'Product ID'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addIndex(
                    $installer->getIdxName(
                        'slog_customer_product_viewed',
                        ['entity_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'slog_customer_product_viewed',
                        'slog_visitor_id',
                        'slog_visitor',
                        'entity_id'
                    ),
                    'slog_visitor_id',
                    $installer->getTable('slog_visitor'),
                    'entity_id',
                    Table::ACTION_CASCADE
                );
            $installer->getConnection()->createTable($productsTable);
        }

        if (!$installer->tableExists('slog_customer_category_viewed')) {
            $categoryTable = $installer->getConnection()
                ->newTable($installer->getTable('slog_customer_category_viewed'))
                ->addColumn(
                    'entity_id',
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                ->addColumn(
                    'slog_visitor_id',
                    Table::TYPE_BIGINT,
                    null,
                    ['unsigned' => true],
                    'Visitor ID'
                )
                ->addColumn(
                    'category_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'Category ID'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addIndex(
                    $installer->getIdxName(
                        'slog_customer_product_viewed',
                        ['entity_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'slog_customer_category_viewed',
                        'slog_visitor_id',
                        'slog_visitor',
                        'entity_id'
                    ),
                    'slog_visitor_id',
                    $installer->getTable('slog_visitor'),
                    'entity_id',
                    Table::ACTION_CASCADE
                );
            $installer->getConnection()->createTable($categoryTable);
        }
    }
}