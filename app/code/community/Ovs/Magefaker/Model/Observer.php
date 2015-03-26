<?php

/**
 * Class Ovs_Magefaker_Model_Observer
 *
 */
class Ovs_Magefaker_Model_Observer{


    /**
     * set the faker autloader
     */
    public function setAutoload(){

        require_once Mage::getBaseDir('lib') . DS . 'Zend' . DS . 'Loader.php';
        $autoLoader = Zend_Loader_Autoloader::getInstance();

        // get all Varien autoloaders an unregister them

        $autoloader_callbacks   = spl_autoload_functions();
        $original_autoload      = null;

        foreach($autoloader_callbacks as $callback) {
            if(is_array($callback) && $callback[0] instanceof Varien_Autoload) {
                $original_autoload = $callback;
            }
        }

        spl_autoload_unregister($original_autoload);

        // the faker autoloader

        function fakerLoader($className) {

            $className = ltrim($className, '\\');
            $fileName  = '';

            if ($lastNsPos = strripos($className, '\\')) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName  = str_replace('\\', DS, $namespace) . DS;
            }

            $fileName = Mage::getBaseDir('lib') . DS . 'fzaninotto' . DS . $fileName . DS . $className . '.php';

            if (file_exists($fileName)) {
                require_once $fileName;

                return true;
            }

            return false;
        }

        $autoLoader->pushAutoloader('fakerLoader', 'Faker\\');

        // re-add the original autoloader

        spl_autoload_register($original_autoload);

    }

}