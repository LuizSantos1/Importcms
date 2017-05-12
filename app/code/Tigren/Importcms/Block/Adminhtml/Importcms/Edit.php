<?php
/**
* Copyright © 2017 Tigren Solutions. All rights reserved.
*/
namespace Tigren\Importcms\Block\Adminhtml\Importcms;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
	protected function _construct()
    {
        parent::_construct();

        $this->buttonList->remove('back');
        $this->buttonList->remove('reset');
        $this->buttonList->update('save', 'label', __('Import CMS Pages'));
        $this->buttonList->update('save', 'id', 'upload_button');
        //$this->buttonList->update('save', 'onclick', 'varienImport.postToFrame();');
        //$this->buttonList->update('save', 'data_attribute', '');

        $this->_objectId = 'import_id';
        $this->_blockGroup = 'Tigren_Importcms';
        $this->_controller = 'adminhtml_importcms';
    }

    public function getHeaderText()
    {
        return __('Import');
    }
}