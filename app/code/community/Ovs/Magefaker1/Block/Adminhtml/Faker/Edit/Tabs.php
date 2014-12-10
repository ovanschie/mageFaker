<?php

/**
 * Class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Tabs
 */
class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
    /**
     * config
     */
    public function __construct(){
        parent::__construct();

        $this->setId('faker_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Faker data'));
    }

    /**
     * Set the tabs
     *
     * @return Mage_Core_Block_Abstract
     * @throws Exception
     */
    protected function _beforeToHtml()
    {

        $this->addTab('adminhtml_tab_insert', 'ovs_magefaker/adminhtml_faker_edit_tabs_insert');
        //$this->addTab('adminhtml_tab_remove', 'ovs_magefaker/adminhtml_faker_edit_tabs_remove');

        return parent::_beforeToHtml();
    }
}