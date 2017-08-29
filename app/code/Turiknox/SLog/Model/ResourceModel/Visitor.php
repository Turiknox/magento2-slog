<?php
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\SLog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Visitor extends AbstractDb
{
    /**
     * Visitor constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Resource initialisation
     */
    protected function _construct()
    {
        $this->_init('slog_visitor', 'entity_id');
    }
}