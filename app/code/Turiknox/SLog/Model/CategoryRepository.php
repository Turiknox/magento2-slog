<?php
namespace Turiknox\SLog\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Turiknox\SLog\Api\CategoryRepositoryInterface;
use Turiknox\SLog\Api\Data\CategoryInterface;
use Turiknox\SLog\Api\Data\CategoryInterfaceFactory;
use Turiknox\SLog\Api\Data\CategorySearchResultInterfaceFactory;
use Turiknox\SLog\Model\ResourceModel\Category as ResourceCategory;
use Turiknox\SLog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourceCategory
     */
    protected $resource;
    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;
    /**
     * @var CategorySearchResultInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var CategoryInterfaceFactory
     */
    protected $categoryInterfaceFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    public function __construct(
        ResourceCategory $resource,
        CategoryCollectionFactory $categoryCollectionFactory,
        CategorySearchResultInterfaceFactory $categorySearchResultInterfaceFactory,
        CategoryInterfaceFactory $categoryInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->searchResultsFactory = $categorySearchResultInterfaceFactory;
        $this->categoryInterfaceFactory = $categoryInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param CategoryInterface $entity
     * @return CategoryInterface
     * @throws CouldNotSaveException
     */
    public function save(CategoryInterface $entity)
    {
        try {
            /** @var CategoryInterface|\Magento\Framework\Model\AbstractModel $entity */
            $this->resource->save($entity);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the category: %1',
                $exception->getMessage()
            ));
        }
        return $entity;
    }

    /**
     * Get category record
     *
     * @param $entityId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($entityId)
    {
        if (!isset($this->_instances[$entityId])) {
            /** @var \Turiknox\SLog\Api\Data\CategoryInterface|\Magento\Framework\Model\AbstractModel $data */
            $data = $this->categoryInterfaceFactory->create();
            $this->resource->load($data, $entityId);
            if (!$data->getId()) {
                throw new NoSuchEntityException(__('Requested category doesn\'t exist'));
            }
            $this->instances[$entityId] = $data;
        }
        return $this->instances[$entityId];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\SLog\Api\Data\CategorySearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Turiknox\SLog\Api\Data\CategorySearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Turiknox\SLog\Model\ResourceModel\Category\Collection $collection */
        $collection = $this->categoryCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            $field = 'entity_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $data = [];
        foreach ($collection as $datum) {
            $dataDataObject = $this->categoryInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($dataDataObject, $datum->getData(), CategoryInterface::class);
            $data[] = $dataDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($data);
    }

    /**
     * @param CategoryInterface $entity
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(CategoryInterface $entity)
    {
        /** @var \Turiknox\SLog\Api\Data\CategoryInterface|\Magento\Framework\Model\AbstractModel $entity */
        $id = $entity->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($entity);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove category %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * @param $entityId
     * @return bool
     */
    public function deleteById($entityId)
    {
        $data = $this->getById($entityId);
        return $this->delete($data);
    }
}
