<?php
/**
* Copyright © 2017 Tigren Solutions. All rights reserved.
*/
namespace Tigren\Importcms\Controller\Adminhtml\Index;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;
	public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute() {
    	$resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Cms::import_cms_page');
        $resultPage->addBreadcrumb(__('CMS'), __('CMS'));
        $resultPage->addBreadcrumb(__('Import CMS Pages'), __('Import CMS Pages'));
        $resultPage->getConfig()->getTitle()->prepend(__('Pages'));

        return $resultPage;
    }
}