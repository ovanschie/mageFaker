<?php

/**
 * Class Threesixty_Customizer_Model_Customizer
 */
class Ovs_MageFaker_Model_Faker extends Mage_Core_Model_Abstract{

    public function _construct()
    {
        parent::_construct();
        $this->_init('ovs_magefaker/faker');
    }

}