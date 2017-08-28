<?php
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\SLog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Turiknox\SLog\Api\Data\ProductInterface;

interface ProductRepositoryInterface
{
    /**
     * @param ProductInterface $entity
     * @return ProductInterface interface
     */
    public function save(ProductInterface $entity);

    /**
     * @param $id
     * @return ProductInterface interface
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\SLog\Api\Data\ProductSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param ProductInterface $entity
     * @return bool
     */
    public function delete(ProductInterface $entity);

    /**
     * @param $entity
     * @return ProductInterface interface
     */
    public function deleteById($entity);
}