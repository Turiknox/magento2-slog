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

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Product search result interface.
 *
 * @api
 */
interface ProductSearchResultInterface extends SearchResultsInterface
{
    /**
     * Gets collection items.
     *
     * @return \Turiknox\SLog\Api\Data\ProductInterface[] Array of collection items.
     */
    public function getItems();

    /**
     * Set collection items.
     *
     * @param \Turiknox\SLog\Api\Data\ProductInterface[]
     * @return $this
     */
    public function setItems(array $items);
}