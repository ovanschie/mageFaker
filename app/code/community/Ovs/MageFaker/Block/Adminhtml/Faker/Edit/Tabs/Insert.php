<?php

/**
 * Class Threesixty_Customizer_Block_Adminhtml_Customizer_Edit_Tabs_About
 */
class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Tabs_Insert extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('Product', array(
            'legend' => $this->__('Product')
        ));

        $fieldset->addField('products', 'select', array(
            'label' => $this->__('Number of products to insert'),
            'required' => true,
            'name' => 'products',
            'value' => '100',
            'values' => array(
                '1' => '1',
                '10' => '10',
                '50' => '50',
                '100' => '100',
                '250' => '250',
                '500' => '500',
                '1000' => '1.000',
                '5000' => '5.000',
                '10000' => '10.000',
                '50000' => '50.000'
            )
        ));


        $form->setUseContainer(false);
        $this->setForm($form);

        return parent::_prepareForm();
    }


    /**
     * @return string
     */
    public function getTabLabel(){
        return $this->__("Insert");
    }

    /**
     * @return string
     */
    public function getTabTitle(){
        return $this->__("Insert");
    }

    /**
     * @return bool
     */
    public function canShowTab(){
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden(){
        return false;
    }
}