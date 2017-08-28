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
use Turiknox\SLog\Api\Data\ProductInterface;

class Product extends AbstractModel
    implements ProductInterface
{

    /**
     * Cache tag
     */
    const CACHE_TAG = 'slog_customer_product_viewed';

    /**
     * Initialise resource model
     */
    protected function _construct()
    {
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
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(ProductInterface::CREATED_AT);
    }
}