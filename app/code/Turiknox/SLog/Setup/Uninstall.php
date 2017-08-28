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

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    /**
     * Drop module tables
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if ($setup->tableExists('slog_customer_product_viewed')) {
            $setup->getConnection()->dropTable('slog_customer_product_viewed');
        }

        if ($setup->tableExists('slog_customer_category_viewed')) {
            $setup->getConnection()->dropTable('slog_customer_category_viewed');
        }

        if ($setup->tableExists('slog_visitor')) {
            $setup->getConnection()->dropTable('slog_visitor');
        }
    }
}