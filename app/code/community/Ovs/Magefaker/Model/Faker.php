<?php

/**
 * Class Ovs_MageFaker_Model_Faker
 */
class Ovs_Magefaker_Model_Faker extends Mage_Core_Model_Abstract{

    public function _construct()
    {
        parent::_construct();
        $this->_init('ovs_magefaker/faker');
    }

    public function insertProducts($count, $categories){

        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        require_once Mage::getBaseDir('lib') . DS .'fzaninotto'. DS .'faker' . DS . 'faker.php';

        $faker = @Faker\Factory::create();
        @$faker->addProvider(new \Faker\Provider\Product($faker));

        $rating_options = array(
            1 => array(1,2,3,4,5),
            2 => array(6,7,8,9,10),
            3 => array(11,12,13,14,15)
        );

        for($i = 0; $i < $count; $i++) {

            $product = Mage::getModel('catalog/product');

            $name   = $faker->productName;
            $sku    = $faker->sku($name);
            $price  = $faker->price;

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
                        ->setTaxClassId(0)//tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)//catalog and search visibility
                        //->setManufacturer(28)//manufacturer id
                        //->setColor(24)
                        ->setNewsFromDate(strtotime('now'))//product set as new from
                        ->setNewsToDate(strtotime("+1 week"))//product set as new to
                        ->setCountryOfManufacture('NL')//country of manufacture (2-letter country code)

                        ->setPrice($price)//price in form 11.22
                        ->setCost(($price * 0.66))//price in form 11.22
                        //->setSpecialPrice(00.44)//special price in form 11.22
                        //->setSpecialFromDate('06/1/2014')//special price from (MM-DD-YYYY)
                        //->setSpecialToDate('06/30/2014')//special price to (MM-DD-YYYY)
                        ->setMsrpEnabled(1)//enable MAP
                        ->setMsrpDisplayActualPriceType(4)//display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
                        ->setMsrp($price)//Manufacturer's Suggested Retail Price

                        ->setMetaTitle($name)
                        ->setMetaKeyword($faker->metaKeys)
                        ->setMetaDescription($faker->metaDescription)
                        ->setDescription($faker->description)
                        ->setShortDescription($faker->shortDescription)
                        ->setMediaGallery(array('images' => array(), 'values' => array()))//media gallery initialization
                        ->addImageToMediaGallery($faker->productImage, array('image', 'thumbnail', 'small_image'), false, false)//assigning image, thumb and small image to media gallery
                        ->addImageToMediaGallery($faker->productImage, array(), false, false)//assigning image, thumb and small image to media gallery
                        ->addImageToMediaGallery($faker->productImage, array(), false, false)//assigning image, thumb and small image to media gallery

                        ->setStockData(array(
                                'use_config_manage_stock' => 1, //'Use config settings' checkbox
                                'manage_stock' => 1, //manage stock
                                'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
                                'max_sale_qty' => 99, //Maximum Qty Allowed in Shopping Cart
                                'is_in_stock' => 1, //Stock Availability
                                'qty' => 999 //qty
                            )
                        )
                        ->setCategoryIds($categories) //assign product to categories
                        ->setUrlKey($name . '-' . $sku);

                    $product->save();

                    $new_productId = $product->getId();

                    $reviewCount = mt_rand(0, 15);

                    for($y = 0; $y < $reviewCount; $y++) {

                        $review = Mage::getModel('review/review');
                        $review->setEntityPkValue($new_productId);
                        $review->setStatusId(1); // approved
                        $review->setTitle($faker->sentence(3));
                        $review->setDetail($faker->sentence(mt_rand(3, 10)));
                        $review->setEntityId(1);
                        $review->setStoreId(0);
                        $review->setCustomerId(null);
                        $review->setNickname($faker->name);
                        $review->setReviewId($review->getId());
                        $review->setStores(array(0, 1));
                        $review->save();

                        foreach($rating_options as $rating_id => $option_ids) {
                            $stars = mt_rand(0, 4);

                            Mage::getModel('rating/rating')
                                ->setRatingId($rating_id)
                                ->setReviewId($review->getId())
                                ->addOptionVote($option_ids[$stars], $new_productId);
                        }

                        $review->aggregate();

                    }

                } catch (Exception $e) {
                    Mage::logException($e);
                    return false;
                }

        }

        return true;
    }

    public function removeProducts(){
        try{
            $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('sku', array('like' => 'magefaker-%'))
                ->load();

            foreach($products as $product){
                    $product->delete();
            }

        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }

        return true;
    }

}