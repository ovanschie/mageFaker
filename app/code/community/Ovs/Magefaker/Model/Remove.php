<?php

class Ovs_Magefaker_Model_Remove extends Mage_Core_Model_Abstract{

    /**
     * Remove products with magefaker prefix
     *
     * @return bool
     */
    public function removeProducts(){
        try{
            $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('sku', array('like' => 'magefaker-%'))
                ->load();

            foreach($products as $product){
                $product->delete();
            }

            return true;

        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * Remove categories with magefaker prefix
     *
     * @return bool
     */
    public function removeCategories(){
        try{
            $categories = Mage::getModel('catalog/category')
                ->getCollection()
                ->addAttributeToFilter('url_key', array('like' => '%magefaker-%'))
                ->load();

            foreach($categories as $category){
                $category->delete();
            }

            return true;

        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}