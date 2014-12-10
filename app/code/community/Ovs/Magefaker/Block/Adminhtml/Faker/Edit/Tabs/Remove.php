<?php

/**
 * Class vs_MageFaker_Block_Adminhtml_Faker_Edit_Tabs_Remove
 */
class Ovs_Magefaker_Block_Adminhtml_Faker_Edit_Tabs_Remove extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Generate form from config xml
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {

//        $form->setUseContainer(false);
//        $this->setForm($form);

        return parent::_prepareForm();
    }


    /**
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__("Remove");
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__("Remove");
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

}