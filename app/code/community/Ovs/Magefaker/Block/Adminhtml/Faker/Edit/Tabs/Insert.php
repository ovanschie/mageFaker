<?php

/**
 * Class Ovs_MageFaker_Block_Adminhtml_Faker_Edit_Tabs_Insert.
 */
class Ovs_Magefaker_Block_Adminhtml_Faker_Edit_Tabs_Insert extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        // category
        $category = $form->addFieldset('category_insert', [
            'legend' => $this->__('Categories'),
        ]);

        $category->addField('categories_parent', 'select', [
            'label'              => $this->__('Parent category'),
            'required'           => true,
            'name'               => 'categories_parent',
            'values'             => Mage::getModel('ovs_magefaker/source_category')->toOptionArray(false),
            'value'              => Mage::getModel('ovs_magefaker/source_category')->getFirstValue(),
            'after_element_html' => 'Appends new categories to this parent',
        ]);

        $category->addField('categories_insert', 'select', [
            'label'  => $this->__('Amount of fake categories to insert'),
            'name'   => 'categories_insert',
            'value'  => '0',
            'values' => [
                '0'   => '0',
                '1'   => '1',
                '2'   => '2',
                '3'   => '3',
                '5'   => '5',
                '10'  => '10',
                '25'  => '25',
                '50'  => '50',
                '100' => '100',
                '250' => '250',
                '500' => '500',
            ],
            'after_element_html' => '(Ignored when using custom categories)',
        ]);

        $category->addField('categories_custom', 'text', [
            'label'              => $this->__('Custom categories'),
            'name'               => 'categories_custom',
            'after_element_html' => 'Use these categories instead of the default MageFaker categories. Comma separated. ',
        ]);

        $category->addField('categories_anchor', 'checkbox', [
            'label'   => $this->__('Make anchor'),
            'name'    => 'categories_anchor',
            'value'   => 1,
            'checked' => true,
        ]);

        $category->addField('categories_image', 'checkbox', [
            'label'   => $this->__('Include image'),
            'name'    => 'categories_image',
            'value'   => 1,
            'checked' => true,
        ]);

        // product
        $product = $form->addFieldset('product_insert', [
            'legend' => $this->__('Products'),
        ]);

        $product->addField('products_category', 'multiselect', [
            'label'              => $this->__('Categories'),
            'required'           => true,
            'name'               => 'products_category',
            'values'             => Mage::getModel('ovs_magefaker/source_category')->toOptionArray(false),
            'value'              => Mage::getModel('ovs_magefaker/source_category')->getFirstValue(),
            'after_element_html' => 'Appends new products to these categories',
        ]);

        $product->addField('products_insert', 'select', [
            'label'  => $this->__('Amount of products to insert of each type'),
            'name'   => 'products_insert',
            'value'  => '0',
            'values' => [
                '0'     => '0',
                '1'     => '1',
                '2'     => '2',
                '3'     => '3',
                '5'     => '5',
                '10'    => '10',
                '25'    => '25',
                '50'    => '50',
                '100'   => '100',
                '250'   => '250',
                '500'   => '500',
                '1000'  => '1.000',
                '5000'  => '5.000',
                '10000' => '10.000',
            ],
        ]);

        $product->addField('products_simple', 'checkbox', [
            'label'   => $this->__('Include simple products'),
            'name'    => 'products_simple',
            'value'   => 1,
            'checked' => true,
        ]);

        $product->addField('products_configurable', 'checkbox', [
            'label'   => $this->__('Include configurable products'),
            'name'    => 'products_configurable',
            'value'   => 1,
            'checked' => true,
        ]);

        $product->addField('products_reviews', 'checkbox', [
            'label'   => $this->__('Include reviews and ratings'),
            'name'    => 'products_reviews',
            'value'   => 1,
            'checked' => true,
        ]);

        $form->setUseContainer(false);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Insert');
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Insert');
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
