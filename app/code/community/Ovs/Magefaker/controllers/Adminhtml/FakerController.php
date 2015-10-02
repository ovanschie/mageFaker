<?php
/**
 * Class Ovs_MageFaker_Adminhtml_FakerController
 *
 * Main controller
 */
class Ovs_Magefaker_Adminhtml_FakerController extends Mage_Adminhtml_Controller_Action{
    
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('system/magefaker');
    }

    /**
     * render main layout
     */
    public function indexAction(){

        $this->loadLayout();

        $this->_title('Faker data');
        $this->_setActiveMenu('system');

        $this->renderLayout();
    }

    /**
     * Process save
     */
    public function saveAction(){

        // set index modes to manual
        $processes = array();
        $indexer = Mage::getSingleton('index/indexer');
        $processCollection = $indexer->getProcessesCollection();

        foreach ($processCollection as $process) {
            $processes[$process->getIndexerCode()] = $process->getMode();

            if($process->getMode() !== Mage_Index_Model_Process::MODE_MANUAL){
                $process->setData('mode', Mage_Index_Model_Process::MODE_MANUAL)->save();
            }
        }

        // remove products
        if($this->getRequest()->getParam('products_remove')) {
            $this->removeProducts();
        }

        // insert products
        if($this->getRequest()->getParam('products_insert') > 0){

            if($this->getRequest()->getParam('products_simple')){
                $this->insertProducts(
                    'simple',
                    $this->getRequest()->getParam('products_insert'),
                    $this->getRequest()->getParam('products_category')
                );
            }

            if($this->getRequest()->getParam('products_configurable')){
                $this->insertProducts(
                    'configurable',
                    $this->getRequest()->getParam('products_insert'),
                    $this->getRequest()->getParam('products_category')
                );
            }

        }

        // remove categories
        if($this->getRequest()->getParam('categories_remove')) {
            $this->removeCategories();
        }

        // insert categories
        if($this->getRequest()->getParam('categories_insert') > 0){
            $this->insertCategories(
                $this->getRequest()->getParam('categories_insert'),
                $this->getRequest()->getParam('categories_parent')
            );
        }

        Mage::getSingleton('adminhtml/session')->addNotice($this->__('Reminder: run indexer when done'));

        // restore index mode
        foreach ($processCollection as $process) {
            $process->setData('mode', $processes[$process->getIndexerCode()])->save();
        }

        $this->_redirectReferer();
    }

    /**
     * Remove all Magefaker products
     */
    private function removeProducts(){
        $model = Mage::getModel('ovs_magefaker/remove');

        $startTime  = new DateTime('NOW');
        $remove     = $model->removeProducts();
        $endTime    = new DateTime('NOW');

        if($remove){
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $this->__('Products removed')
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(
                $this->__('An error occurred while removing products')
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
    }

    /**
     * insert products by type
     *
     * @param $type
     * @param $count
     * @param $category
     */
    private function insertProducts($type, $count, $category){
        $model = Mage::getModel('ovs_magefaker/faker');

        $startTime = new DateTime('NOW');

        if($type == 'simple'){
            $insert = $model->insertSimpleProducts($count, $category);
        }
        else if($type == 'configurable'){
            $insert = $model->insertConfigurableProducts($count, $category);
        }

        $endTime = new DateTime('NOW');

        if($insert){
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $count . ' ' .
                $this->__('%s product(s) inserted', $type)
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(
                $this->__('An error occurred while inserting')
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
    }

    /**
     * Removes categories
     */
    private function removeCategories(){
        $model = Mage::getModel('ovs_magefaker/remove');

        $startTime  = new DateTime('NOW');
        $remove     = $model->removeCategories();
        $endTime    = new DateTime('NOW');

        if($remove){
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $this->__('Categories removed')
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(
                $this->__('An error occurred while removing categories')
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
    }
    /**
     * Insert categories
     *
     * @param $count
     * @param $parentCategory
     */
    private function insertCategories($count, $parentCategory){
        $model = Mage::getModel('ovs_magefaker/faker');

        $startTime  = new DateTime('NOW');
        $insert     = $model->insertCategories($count, $parentCategory);
        $endTime    = new DateTime('NOW');

        if($insert){
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $count . ' ' .
                $this->__('Categorie(s) inserted')
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(
                $this->__('An error occurred while inserting')
                . ' - ' . $this->getElapsedTime($startTime, $endTime)
            );
        }
    }

    /**
     * Returns elapsed time
     *
     * @param $start
     * @param $end
     * @return mixed
     */
    private function getElapsedTime($start, $end){
        $diff = $start->diff( $end );
        return $diff->format( '%H:%I:%S' );
    }

}