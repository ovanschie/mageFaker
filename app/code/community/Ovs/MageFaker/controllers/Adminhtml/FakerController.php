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

    }
}