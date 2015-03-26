<?php

/**
 * Class Ovs_MageFaker_Model_Faker
 */
class Ovs_Magefaker_Model_Source_Category extends Mage_Core_Model_Abstract{

   public function toOptionArray($addEmpty = true){
          $tree = Mage::getResourceModel('catalog/category_tree');

          $collection = Mage::getResourceModel('catalog/category_collection');

          $collection->addAttributeToSelect('name')
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
                 'value' => $category->getId()
              );
          }

          return $options;
    }

    public function getFirstValue(){
        $values = $this->toOptionArray(false);
        return $values[0];
    }
}