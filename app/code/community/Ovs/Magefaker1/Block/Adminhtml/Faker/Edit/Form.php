<?php

/**
 * Class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Form
 */
class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    /**
     * create the form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     * @throws Exception
     */
    protected function _prepareForm()
    {
        // edit form
        $edit_form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $edit_form->setUseContainer(true);
        $this->setForm($edit_form);

        return parent::_prepareForm();
    }

}