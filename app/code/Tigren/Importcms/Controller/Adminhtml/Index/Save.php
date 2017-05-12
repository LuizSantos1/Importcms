<?php
/**
* Copyright © 2017 Tigren Solutions. All rights reserved.
*/
namespace Tigren\Importcms\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;

use Magento\Cms\Model\Page;

class Save extends Action 
{
	protected $fileSystem;
    protected $uploaderFactory;
    protected $fileId = 'import_file';
    protected $allowedExtensions = ['csv'];
    protected $csvProcessor;

	public function execute()
    {
    	$destinationPath = $this->getDestinationPath();
    	$resultRedirect = $this->resultRedirectFactory->create();
    	try {
            $uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
                ->setAllowCreateFolders(true)
                ->setAllowedExtensions($this->allowedExtensions);
            $uploader->setAllowRenameFiles(true);
            if (!$uploader->checkAllowedExtension($uploader->getFileExtension())) {
	            throw new \Magento\Framework\Exception\LocalizedException(
	                new \Magento\Framework\Phrase('Invalid file type.')
	            );
	        }

            if (!$uploader->save($destinationPath)) {
                throw new LocalizedException(
                    __('File cannot be saved to path: $1', $destinationPath)
                );
            }
            $uploadedFile = $destinationPath . '/' . $uploader->getUploadedFileName();
            $importProductRawData = $this->csvProcessor->getData($uploadedFile);
            foreach ($importProductRawData as $rowIndex => $dataRow) {
            	if ($rowIndex == 0) {
            		continue;
            	}
            	$model = $this->_objectManager->create('Magento\Cms\Model\Page');
            	$data = array(
            		'title' => $dataRow[1],
            		'content_heading' => $dataRow[6],
            		'identifier' => $dataRow[5],
            		'meta_title' => '',
            		'is_active' => $dataRow[10],
            		'content' => $dataRow[7],
            		'meta_keywords' => $dataRow[3],
            		'meta_description' => $dataRow[4],
            		'layout_update_xml' => $dataRow[12],
            		'custom_theme' => $dataRow[13],
            		'custom_root_template' => $dataRow[14],
            		'custom_theme_from' => $dataRow[16],
            		'custom_theme_to' => $dataRow[17]
            	);
            	$pageLayout = $dataRow['2'];
            	switch ($pageLayout) {
            		case 'empty':
            			$data['page_layout'] = 'empty';
            			break;
            		case 'one_column':
            			$data['page_layout'] = '1column';
            			break;
            		case 'two_columns_left':
            			$data['page_layout'] = '2columns-left';
            			break;
            		case 'two_columns_right':
            			$data['page_layout'] = '2columns-right';
            			break;
            		case 'three_columns':
            			$data['page_layout'] = '3columns';
            			break;	
            		default:
            			$data['page_layout'] = '1column';
            			break;
            	}
            	$data['store_id'] = array(0);
            	$model->setData($data);
            	$model->save();
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __($e->getMessage())
            );
    		return $resultRedirect->setPath('*/*/');
        }
    	$this->messageManager->addSuccess(__('CMS Pages imported successfully.'));
    	return $resultRedirect->setPath('*/*/');
    }

    public function __construct(
        Action\Context $context,
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory, 
        \Magento\Framework\File\Csv $csvProcessor
    ) {
    	$this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->csvProcessor = $csvProcessor;
        parent::__construct($context);
    }

    public function getDestinationPath()
    {
        return $this->fileSystem
            ->getDirectoryWrite(DirectoryList::VAR_DIR)
            ->getAbsolutePath('cms');
    }
}