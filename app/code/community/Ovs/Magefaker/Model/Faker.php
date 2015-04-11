<?php

/**
 * Class Ovs_MageFaker_Model_Faker
 */
class Ovs_Magefaker_Model_Faker extends Mage_Core_Model_Abstract{

    public function _construct(){
        parent::_construct();
        $this->_init('ovs_magefaker/faker');
    }

    /**
     * Generates products and product reviews
     *
     * @param $count
     * @param $categories
     * @return bool
     */
    public function insertProducts($count, $categories){

        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $faker = new Faker\Generator();
        $faker->addProvider(new Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\Product($faker));

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
                        ->setWebsiteIds(array(1))
                        ->setAttributeSetId(4) // default set
                        ->setTypeId('simple')
                        ->setCreatedAt(strtotime('now'))

                        ->setSku($sku)
                        ->setName($name)
                        ->setUrlKey($name . '-' . $sku)
                        ->setCategoryIds($categories)
                        ->setWeight($faker->weight)

                        ->setStatus(1) // product status (1 - enabled, 2 - disabled)
                        ->setTaxClassId(0) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                        ->setNewsFromDate(strtotime('now'))
                        ->setNewsToDate(strtotime("+1 week"))
                        ->setCountryOfManufacture('NL')

                        ->setPrice($price)
                        ->setCost(($price * 0.66))
                        ->setMsrpEnabled(1)
                        ->setMsrpDisplayActualPriceType(4) // display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
                        ->setMsrp($price)

                        ->setMetaTitle($name)
                        ->setMetaKeyword($faker->metaKeys)
                        ->setMetaDescription($faker->metaDescription)
                        ->setDescription($faker->description)
                        ->setShortDescription($faker->shortDescription)

                        ->setMediaGallery(array('images' => array(), 'values' => array()))
                        ->addImageToMediaGallery($faker->productImage, array('image', 'thumbnail', 'small_image'), false, false)
                        ->addImageToMediaGallery($faker->productImage, array(), false, false)
                        ->addImageToMediaGallery($faker->productImage, array(), false, false)

                        ->setStockData(array(
                                'use_config_manage_stock' => 1,
                                'manage_stock' => 1,
                                'min_sale_qty' => 1,
                                'max_sale_qty' => 99,
                                'is_in_stock' => 1,
                                'qty' => 999
                            )
                        );

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


    /**
     * Removes products with magefaker prefix
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

        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }

        return true;
    }

    /**
     * Generates categories
     *
     * @param $count
     * @return bool
     */
    public function insertCategories($count, $parentId){

        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $faker = new Faker\Generator();
        $faker->addProvider(new Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\Product($faker));

        for($i = 0; $i < $count; $i++) {

            try{
                $name = $faker->categoryName();
                $parentCategory = Mage::getModel('catalog/category')->load($parentId);

                $category = Mage::getModel('catalog/category');
                $category->setName($name);
                $category->setUrlKey('magefaker-' . $faker->categoryUrl($name));
                $category->setIsActive(1);
                $category->setDisplayMode('PRODUCTS');
                $category->setIsAnchor(1);
                $category->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID);
                $category->setPath($parentCategory->getPath());
                $category->save();

            } catch(Exception $e) {
                Mage::logException($e);
                return false;
            }

        }

        return true;
    }

    /**
     * Removes categories with magefaker prefix
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

        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }

        return true;
    }
}