<?php
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\SLog\Model;

use Magento\Framework\Model\AbstractModel;
use Turiknox\SLog\Api\Data\VisitorInterface;

class Visitor extends AbstractModel implements VisitorInterface
{

    /**
     * Cache tag
     */
    const CACHE_TAG = 'slog_visitor';

    /**
     * Initialise resource model
     */
    protected function _construct()
    {
        $this->_init('Turiknox\SLog\Model\ResourceModel\Visitor');
    }

    /**
     * Get cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Visitor ID
     *
     * @return int
     */
    public function getVisitorId()
    {
        return $this->getData(VisitorInterface::VISITOR_ID);
    }

    /**
     * Get Customer ID
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(VisitorInterface::CUSTOMER_ID);
    }

    /**
     * Get Customer IP
     *
     * @return string
     */
    public function getCustomerIp()
    {
        return $this->getData(VisitorInterface::CUSTOMER_IP);
    }

    /**
     * Get Last Visit At
     *
     * @return string
     */
    public function getLastVisitAt()
    {
        return $this->getData(VisitorInterface::LAST_VISIT_AT);
    }
}
