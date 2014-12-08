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

    public function insertProducts($count){

        require_once Mage::getBaseDir('lib') . DS .'fzaninotto'. DS .'faker' . DS . 'src' . DS . 'autoload.php';

        for($i = 0; $i < $count; $i++) {

            Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            $product = Mage::getModel('catalog/product');

            $faker = Faker\Factory::create();
            $faker->addProvider(new \Faker\Provider\Product($faker));

            $name   = $faker->productName;
            $sku    = $faker->sku($name);
            $price  = $faker->price;

            if (!$product->getIdBySku($sku)){

                try {
                    $product
                        ->setWebsiteIds(array(1))//website ID the product is assigned to, as an array
                        ->setAttributeSetId(4)//ID of a attribute set named 'default'
                        ->setTypeId('simple')//product type
                        ->setCreatedAt(strtotime('now'))//product creation time
                        ->setSku($sku)//SKU
                        ->setName($name)//product name
                        ->setWeight($faker->weight)
                        ->setStatus(1)//product status (1 - enabled, 2 - disabled)
                        ->setTaxClassId(1)//tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)//catalog and search visibility
                        ->setManufacturer(28)//manufacturer id
                        ->setColor(24)
                        ->setNewsFromDate(strtotime('now'))//product set as new from
                        ->setNewsToDate(strtotime("+1 week"))//product set as new to
                        ->setCountryOfManufacture('NL')//country of manufacture (2-letter country code)

                        ->setPrice($price)//price in form 11.22
                        ->setCost(($price * 0.66))//price in form 11.22
                        //->setSpecialPrice(00.44)//special price in form 11.22
                        //->setSpecialFromDate('06/1/2014')//special price from (MM-DD-YYYY)
                        //->setSpecialToDate('06/30/2014')//special price to (MM-DD-YYYY)
                        ->setMsrpEnabled(1)//enable MAP
                        ->setMsrpDisplayActualPriceType(1)//display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
                        ->setMsrp($price)//Manufacturer's Suggested Retail Price

                        ->setMetaTitle('test meta title 2')
                        ->setMetaKeyword('test meta keyword 2')
                        ->setMetaDescription('test meta description 2')
                        ->setDescription($faker->description)
                        ->setShortDescription($faker->shortDescription)
                        ->setMediaGallery(array('images' => array(), 'values' => array()))//media gallery initialization
                        //->addImageToMediaGallery('media/catalog/product/1/0/10243-1.png', array('image', 'thumbnail', 'small_image'), false, false)//assigning image, thumb and small image to media gallery

                        ->setStockData(array(
                                'use_config_manage_stock' => 1, //'Use config settings' checkbox
                                'manage_stock' => 1, //manage stock
                                'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
                                'max_sale_qty' => 99, //Maximum Qty Allowed in Shopping Cart
                                'is_in_stock' => 1, //Stock Availability
                                'qty' => 999 //qty
                            )
                        )
                        ->setCategoryIds(array(0)); //assign product to categories

                    $product->save();

                } catch (Exception $e) {
                    Mage::logException($e);
                    return false;
                }

            }

        }

        return true;

    }
}