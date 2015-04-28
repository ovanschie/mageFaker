<?php

/**
 * Class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Tabs_Insert
 */
class Ovs_Magefaker_Block_Adminhtml_Faker_Edit_Tabs_Insert extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();

        // category
        $category = $form->addFieldset('category_insert', array(
            'legend' => $this->__('Categories')
        ));

        $category->addField('categories_parent', 'select', array(
            'label'     => $this->__('Parent'),
            'required'  => true,
            'name'      => 'categories_parent',
            'values'    => Mage::getModel('ovs_magefaker/source_category')->toOptionArray(false),
            'value'     => Mage::getModel('ovs_magefaker/source_category')->getFirstValue(),
            'after_element_html' => 'Will append new categories to this parent',
        ));

        $category->addField('categories_insert', 'select', array(
            'label' => $this->__('Number of categories to insert'),
            'name' => 'categories_insert',
            'value' => '0',
            'values' => array(
                '0' => '0',
                '1' => '1',
                '5' => '5',
                '10' => '10',
                '25' => '25',
                '50' => '50',
                '100' => '100',
                '150' => '150',
                '250' => '250',
                '500' => '500'
            )
        ));

        // product
        $product = $form->addFieldset('product_insert', array(
            'legend' => $this->__('Products')
        ));

        $product->addField('products_category', 'multiselect', array(
            'label'     => $this->__('Select categories'),
            'required'  => true,
            'name'      => 'products_category',
            'values'    => Mage::getModel('ovs_magefaker/source_category')->toOptionArray(false),
            'value'     => Mage::getModel('ovs_magefaker/source_category')->getFirstValue()
        ));

        $product->addField('products_insert', 'select', array(
            'label' => $this->__('Number of products to insert'),
            'name' => 'products_insert',
            'value' => '0',
            'values' => array(
                '0' => '0',
                '1' => '1',
                '10' => '10',
                '50' => '50',
                '100' => '100',
                '250' => '250',
                '500' => '500',
                '1000' => '1.000',
                '5000' => '5.000',
                '10000' => '10.000'
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