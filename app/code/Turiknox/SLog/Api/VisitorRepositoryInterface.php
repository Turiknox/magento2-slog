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
use Turiknox\SLog\Api\Data\VisitorInterface;

interface VisitorRepositoryInterface
{
    /**
     * @param VisitorInterface $entity
     * @return VisitorInterface interface
     */
    public function save(VisitorInterface $entity);

    /**
     * @param $id
     * @return VisitorInterface interface
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\SLog\Api\Data\VisitorSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param VisitorInterface $entity
     * @return bool
     */
    public function delete(VisitorInterface $entity);

    /**
     * @param $entity
     * @return VisitorInterface interface
     */
    public function deleteById($entity);
}