<?php

/**
 * Class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Form.
 */
class Ovs_Magefaker_Block_Adminhtml_Faker_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    /**
     * create the form.
     *
     * @throws Exception
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        // edit form
        $edit_form = new Varien_Data_Form([
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('id')]),
            'method'  => 'post',
            'enctype' => 'multipart/form-data',
        ]);

        $edit_form->setUseContainer(true);
        $this->setForm($edit_form);

        return parent::_prepareForm();
    }
}
