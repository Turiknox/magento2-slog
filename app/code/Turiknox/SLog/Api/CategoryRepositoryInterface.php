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
use Turiknox\SLog\Api\Data\CategoryInterface;

interface CategoryRepositoryInterface
{
    /**
     * @param CategoryInterface $entity
     * @return CategoryInterface interface
     */
    public function save(CategoryInterface $entity);

    /**
     * @param $id
     * @return CategoryInterface interface
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\SLog\Api\Data\CategorySearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param CategoryInterface $entity
     * @return bool
     */
    public function delete(CategoryInterface $entity);

    /**
     * @param $entity
     * @return CategoryInterface interface
     */
    public function deleteById($entity);
}