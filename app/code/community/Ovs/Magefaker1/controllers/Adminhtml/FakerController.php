<?php
/**
 * Class Ovs_MageFaker_Adminhtml_FakerController
 *
 * Main controller
 */
class Ovs_MageFaker_Adminhtml_FakerController extends Mage_Adminhtml_Controller_Action{

    //protected $_publicActions = array('index');

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

        $model = Mage::getModel('ovs_magefaker/faker');

        // set index modes to manual
        $processes = array();
        $indexer = Mage::getSingleton('index/indexer');

        foreach ($indexer->getProcessesCollection() as $process) {
            $processes[$process->getIndexerCode()] = $process->getMode();

            if($process->getMode() != Mage_Index_Model_Process::MODE_MANUAL){
                $process->setData('mode', 'manual')->save();
            }
        }

        $insert = $model->insertProducts($this->getRequest()->getParam('products'));

        if($insert){
            Mage::getSingleton('adminhtml/session')->addSuccess($this->getRequest()->getParam('products') . ' ' . $this->__('Product(s) inserted'));
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while inserting'));
        }

        // restore index mode
        foreach ($indexer->getProcessesCollection() as $process) {
            $process->reindexAll();
            $process->setData('mode', $processes[$process->getIndexerCode()])->save();
        }

        $this->_redirectReferer();
    }
}