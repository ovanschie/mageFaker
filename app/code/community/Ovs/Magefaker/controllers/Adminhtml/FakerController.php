<?php
/**
 * Class Ovs_MageFaker_Adminhtml_FakerController
 *
 * Main controller
 */
class Ovs_Magefaker_Adminhtml_FakerController extends Mage_Adminhtml_Controller_Action{

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
     * Process
     */
    public function saveAction(){
        $startTime  = new DateTime('NOW');

        $model = Mage::getModel('ovs_magefaker/faker');

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

        if($this->getRequest()->getParam('products_remove')) {
            $remove = $model->removeProducts();

            $endTime = new DateTime('NOW');

            if($remove){
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__('Products removed')
                    . ' - ' . $this->getElapsedTime($startTime, $endTime)
                );

                Mage::getSingleton('adminhtml/session')->addNotice($this->__('Reminder: run indexer when done'));

            }
            else{
                Mage::getSingleton('adminhtml/session')->addError(
                    $this->__('An error occurred while removing products')
                    . ' - ' . $this->getElapsedTime($startTime, $endTime)
                );
            }
        }

        if($this->getRequest()->getParam('products_insert') > 0){
            $insert = $model->insertProducts($this->getRequest()->getParam('products_insert'), $this->getRequest()->getParam('products_category'));

            $endTime = new DateTime('NOW');

            if($insert){
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->getRequest()->getParam('products_insert') . ' ' .
                    $this->__('Product(s) inserted')
                    . ' - ' . $this->getElapsedTime($startTime, $endTime)
                );

                Mage::getSingleton('adminhtml/session')->addNotice($this->__('Reminder: run indexer when done'));

            }
            else{
                Mage::getSingleton('adminhtml/session')->addError(
                    $this->__('An error occurred while inserting')
                    . ' - ' . $this->getElapsedTime($startTime, $endTime)
                );
            }
        }


        // restore index mode

        foreach ($processCollection as $process) {
            //$process->reindexEverything();
            $process->setData('mode', $processes[$process->getIndexerCode()])->save();
        }

        $this->_redirectReferer();
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