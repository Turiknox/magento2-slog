<?php
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\SLog\Controller\Adminhtml\Products;

use Turiknox\SLog\Controller\Adminhtml\AbstractController;

class Index extends AbstractController
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page $resultPage
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $this->_setActiveMenu('Turiknox_SLog::products_viewed');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Products Viewed'));
        return $resultPage;
    }
}