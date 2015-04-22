<?php

/**
 * Class Ovs_MageFaker_Model_Faker
 */
class Ovs_Magefaker_Model_Source_Category extends Mage_Core_Model_Abstract{

    protected $options = array();

    /**
     * @param bool $addEmpty
     * @return array
     * @throws Mage_Core_Exception
     */
    public function toOptionArray($addEmpty = true){

        if ($addEmpty) {
            $this->options[] = array(
                'label' => Mage::helper('adminhtml')->__('-- Please Select a Category --'),
                'value' => ''
            );
        }

        $depth      = 6;
        $parentId   = 1;

        $category   = Mage::getModel('catalog/category');
        $categories = $category->getCategories($parentId, $depth, TRUE, FALSE, TRUE);

        foreach ($categories as $node) {

            if ($node->hasChildren()) {
                $this->options[] = array(
                    'label' => $node->getName(),
                    'style' => 'font-weight:bold',
                    'value' => $node->getEntityId()
                );

                $this->_getChildOptions($node->getChildren());
            }
            else{
                $this->options[] = array(
                    'label' => $node->getName(),
                    'value' => $node->getEntityId()
                );
            }

        }

        return $this->options;
    }

    /**
     * Makes options from child category
     *
     * @param Varien_Data_Tree_Node_Collection $nodeCollection
     */
    protected function _getChildOptions(Varien_Data_Tree_Node_Collection $nodeCollection)
    {

        foreach ($nodeCollection as $node) {

            $repeat = $node->getLevel() * 2;

            if($repeat <= 4){
                $repeat = 2;
            }

            $prefix = str_repeat(html_entity_decode('&nbsp;'), $repeat);

            if ($node->hasChildren()) {
                $this->options[] = array(
                    'label' => $prefix  . $node->getName(),
                    'style' => 'font-weight:bold',
                    'value' => $node->getEntityId()
                );

                $this->_getChildOptions($node->getChildren());
            }
            else{
                $this->options[] = array(
                    'label' => $prefix . html_entity_decode('&nbsp;') . $node->getName(),
                    'value' => $node->getEntityId()
                );
            }

        }

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