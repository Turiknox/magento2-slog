<?php
/*
 * Turiknox_SLog

 * @category   Turiknox
 * @package    Turiknox_SLog
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-slog/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\SLog\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

abstract class AbstractController extends Action
{

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Result Page Factory
     *
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Result Forward Factory
     *
     * @var ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * Data constructor.
     *
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Context $context

    ) {
        $this->_coreRegistry         = $registry;
        $this->_resultPageFactory    = $resultPageFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }
}