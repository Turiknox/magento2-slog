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

interface CategoryInterface
{
    const ENTITY_ID         = 'entity_id';
    const SLOG_VISITOR_ID   = 'slog_visitor_id';
    const CATEGORY_ID       = 'category_id';
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
     * @return string
     */
    public function getSlogVisitorId();

    /**
     * Get Category ID
     *
     * @return mixed
     */
    public function getCategoryId();

    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt();
}