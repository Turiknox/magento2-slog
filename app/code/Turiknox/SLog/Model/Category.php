<?php
namespace Turiknox\SLog\Model;
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\Model\AbstractModel;
use Turiknox\SLog\Api\Data\CategoryInterface;

class Category extends AbstractModel
    implements CategoryInterface
{

    /**
     * Cache tag
     */
    const CACHE_TAG = 'slog_customer_category_viewed';

    /**
     * Initialise resource model
     */
    protected function _construct()
    {
        $this->_init('Turiknox\SLog\Model\ResourceModel\Category');
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
     * Get SLog Visitor ID
     *
     * @return int
     */
    public function getSlogVisitorId()
    {
        return $this->getData(CategoryInterface::SLOG_VISITOR_ID);
    }

    /**
     * Get Category ID
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->getData(CategoryInterface::CATEGORY_ID);
    }

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(CategoryInterface::CREATED_AT);
    }
}