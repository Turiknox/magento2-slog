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
use Turiknox\SLog\Api\Data\ProductInterface;

class Product extends AbstractModel implements ProductInterface
{

    /**
     * Cache tag
     */
    const CACHE_TAG = 'slog_customer_product_viewed';

    /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Turiknox\SLog\Model\ResourceModel\Product');
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
        return $this->getData(ProductInterface::SLOG_VISITOR_ID);
    }

    /**
     * Get Product ID
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->getData(ProductInterface::PRODUCT_ID);
    }

    /**
     * Get Store ID
     *
     * @return int
     */
    public function getStoreId()
    {
        return $this->getData(ProductInterface::STORE_ID);
    }

    /**
     * Get Has Ordered
     *
     * @return bool
     */
    public function getHasOrdered()
    {
        return $this->getData(ProductInterface::HAS_ORDERED);
    }

    /**
     * Get View Count
     *
     * @return bool
     */
    public function getViewCount()
    {
        return $this->getData(ProductInterface::VIEW_COUNT);
    }

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(ProductInterface::CREATED_AT);
    }
}
