<?php

/**
 * Class Ovs_MageFaker_Model_Faker
 */
class Ovs_Magefaker_Model_Source_Category extends Mage_Core_Model_Abstract{

    /**
     * @param bool $addEmpty
     * @return array
     * @throws Mage_Core_Exception
     */
    public function toOptionArray($addEmpty = true){
          $collection = Mage::getResourceModel('catalog/category_collection');

          $collection->addAttributeToSelect('name')
              ->addAttributeToSort('path', 'asc')
              ->load();

          $options = array();

          if ($addEmpty) {
              $options[] = array(
                  'label' => Mage::helper('adminhtml')->__('-- Please Select a Category --'),
                  'value' => ''
              );
          }

          foreach ($collection as $category) {

              $options[] = array(
                  'label' => $category->getName(),
                  'level' => $category->getLevel(),
                  'value' => $category->getId()
              );
          }

          return $options;
    }

    /**
     * Returns first value of option array
     *
     * @return mixed
     */
    public function getFirstValue(){
        $values = $this->toOptionArray(false);
        return $values[0];
    }
}