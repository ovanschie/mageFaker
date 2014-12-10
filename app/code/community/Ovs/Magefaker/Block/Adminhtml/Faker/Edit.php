<?php

/**
 * Class Ovs_MageFaker_Block_Adminhtml_Faker_Edit
 */
class Ovs_Magefaker_Block_Adminhtml_Faker_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct()
    {
        parent::__construct();

        $this->_objectId    = 'id';
        $this->_blockGroup  = 'ovs_magefaker';
        $this->_controller  = 'adminhtml_faker';

        $this->_removeButton('back');
        $this->_removeButton('reset');
        $this->_removeButton('save');

        $this->_addButton('start', array(
            'label' => $this->__('Start'),
            'onclick' => 'editForm.submit();',
            'class' => 'save',
        ), -100);
    }

    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
            return $this->__('Faker data');
    }

}