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
use Turiknox\SLog\Api\ProductRepositoryInterface;
use Turiknox\SLog\Api\Data\ProductInterface;
use Turiknox\SLog\Api\Data\ProductInterfaceFactory;
use Turiknox\SLog\Api\Data\ProductSearchResultInterfaceFactory;
use Turiknox\SLog\Model\ResourceModel\Product as ResourceProduct;
use Turiknox\SLog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourceProduct
     */
    protected $resource;
    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;
    /**
     * @var ProductSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var ProductInterfaceFactory
     */
    protected $productInterfaceFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    public function __construct(
        ResourceProduct $resource,
        ProductCollectionFactory $productCollectionFactory,
        ProductSearchResultInterfaceFactory $productSearchResultInterfaceFactory,
        ProductInterfaceFactory $productInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->searchResultsFactory = $productSearchResultInterfaceFactory;
        $this->productInterfaceFactory = $productInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param ProductInterface $entity
     * @return ProductInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductInterface $entity)
    {
        try {
            /** @var ProductInterface|\Magento\Framework\Model\AbstractModel $entity */
            $this->resource->save($entity);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the product: %1',
                $exception->getMessage()
            ));
        }
        return $entity;
    }

    /**
     * Get product record
     *
     * @param $entityId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($entityId)
    {
        if (!isset($this->instances[$entityId])) {
            /** @var \Turiknox\SLog\Api\Data\ProductInterface|\Magento\Framework\Model\AbstractModel $data */
            $data = $this->productInterfaceFactory->create();
            $this->resource->load($data, $entityId);
            if (!$data->getId()) {
                throw new NoSuchEntityException(__('Requested product doesn\'t exist'));
            }
            $this->instances[$entityId] = $data;
        }
        return $this->instances[$entityId];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\SLog\Api\Data\ProductSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Turiknox\SLog\Api\Data\ProductSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Turiknox\SLog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->productCollectionFactory->create();

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
            $dataDataObject = $this->productInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($dataDataObject, $datum->getData(), ProductInterface::class);
            $data[] = $dataDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($data);
    }

    /**
     * @param ProductInterface $entity
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(ProductInterface $entity)
    {
        /** @var \Turiknox\SLog\Api\Data\ProductInterface|\Magento\Framework\Model\AbstractModel $entity */
        $id = $entity->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($entity);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove product %1', $id)
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
