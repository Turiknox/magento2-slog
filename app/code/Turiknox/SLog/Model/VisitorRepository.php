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
use Turiknox\SLog\Api\VisitorRepositoryInterface;
use Turiknox\SLog\Api\Data\VisitorInterface;
use Turiknox\SLog\Api\Data\VisitorInterfaceFactory;
use Turiknox\SLog\Api\Data\VisitorSearchResultInterfaceFactory;
use Turiknox\SLog\Model\ResourceModel\Visitor as ResourceVisitor;
use Turiknox\SLog\Model\ResourceModel\Visitor\CollectionFactory as VisitorCollectionFactory;

class VisitorRepository implements VisitorRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourceVisitor
     */
    protected $resource;
    /**
     * @var VisitorCollectionFactory
     */
    protected $visitorCollectionFactory;
    /**
     * @var VisitorSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var VisitorInterfaceFactory
     */
    protected $visitorInterfaceFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    public function __construct(
        ResourceVisitor $resource,
        VisitorCollectionFactory $visitorCollectionFactory,
        VisitorSearchResultInterfaceFactory $visitorSearchResultInterfaceFactory,
        VisitorInterfaceFactory $visitorInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->visitorCollectionFactory = $visitorCollectionFactory;
        $this->searchResultsFactory = $visitorSearchResultInterfaceFactory;
        $this->visitorInterfaceFactory = $visitorInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param VisitorInterface $entity
     * @return VisitorInterface
     * @throws CouldNotSaveException
     */
    public function save(VisitorInterface $entity)
    {
        try {
            /** @var VisitorInterface|\Magento\Framework\Model\AbstractModel $entity */
            $this->resource->save($entity);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the visitor: %1',
                $exception->getMessage()
            ));
        }
        return $entity;
    }

    /**
     * Get visitor record
     *
     * @param $entityId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($entityId)
    {
        if (!isset($this->_instances[$entityId])) {
            /** @var \Turiknox\SLog\Api\Data\VisitorInterface|\Magento\Framework\Model\AbstractModel $data */
            $data = $this->visitorInterfaceFactory->create();
            $this->resource->load($data, $entityId);
            if (!$data->getId()) {
                throw new NoSuchEntityException(__('Requested visitor doesn\'t exist'));
            }
            $this->instances[$entityId] = $data;
        }
        return $this->instances[$entityId];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\SLog\Api\Data\VisitorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Turiknox\SLog\Api\Data\VisitorSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Turiknox\SLog\Model\ResourceModel\Visitor\Collection $collection */
        $collection = $this->visitorCollectionFactory->create();

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
            $dataDataObject = $this->visitorInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($dataDataObject, $datum->getData(), VisitorInterface::class);
            $data[] = $dataDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($data);
    }

    /**
     * @param VisitorInterface $entity
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(VisitorInterface $entity)
    {
        /** @var \Turiknox\SLog\Api\Data\VisitorInterface|\Magento\Framework\Model\AbstractModel $entity */
        $id = $entity->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($entity);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove visitor %1', $id)
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
