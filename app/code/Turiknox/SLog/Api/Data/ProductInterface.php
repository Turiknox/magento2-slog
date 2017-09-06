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

interface ProductInterface
{
    const ENTITY_ID         = 'entity_id';
    const SLOG_VISITOR_ID   = 'slog_visitor_id';
    const PRODUCT_ID        = 'product_id';
    const STORE_ID          = 'store_id';
    const VIEW_COUNT        = 'view_count';
    const HAS_ORDERED       = 'has_ordered';
    const CREATED_AT        = 'created_at';

    /**
     * Get Entity ID
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Get SLog Visitor ID
     *
     * @return int|null
     */
    public function getSlogVisitorId();

    /**
     * Get Category ID
     *
     * @return int|null
     */
    public function getProductId();

    /**
     * Get Store ID
     *
     * @return int
     */
    public function getStoreId();

    /**
     * Get View Count
     *
     * @return int
     */
    public function getViewCount();

    /**
     * Get Has Ordered
     *
     * @return bool
     */
    public function getHasOrdered();

    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt();
}
