<?php
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\SLog\Api\Data;

interface VisitorInterface
{
    const ENTITY_ID       = 'entity_id';
    const VISITOR_ID      = 'visitor_id';
    const CUSTOMER_ID     = 'customer_id';
    const CUSTOMER_IP     = 'customer_ip';
    const LAST_VISIT_AT   = 'last_visit_at';

    /**
     * Get Entity ID
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Get Visitor ID
     *
     * @return int|null
     */
    public function getVisitorId();

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Get Customer IP
     *
     * @return string
     */
    public function getCustomerIp();

    /**
     * Get Last Visit At
     *
     * @return string
     */
    public function getLastVisitAt();
}
