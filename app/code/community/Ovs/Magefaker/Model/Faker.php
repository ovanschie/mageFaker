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
     * Insert simple products
     *
     * @param $count
     * @param $category
     * @return bool
     */
    public function insertSimpleProducts($count, $category){
        for($i = 0; $i < $count; $i++) {
            $this->insertProduct($category, 'simple');
        }

        return true;
    }


    /**
     * @TODO
     *
     * @param $count
     * @param $category
     * @return bool
     * @throws Mage_Core_Exception
     */
    public function insertConfigurableProducts($count, $category){
        $color_code = 'magefaker_color';
        $size_code  = 'magefaker_size';

        $color  = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product', $color_code);
        $size   = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product', $size_code);

        // check if attributes exist
        if(!$color->getId()){
            $this->insertAttribute($color_code, 'select');
        }

        if(!$size->getId()){
            $this->insertAttribute($size_code, 'select');
        }

        for($i = 0; $i < $count; $i++) {
            $this->insertProduct($category, 'configurable');
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
        $faker->addProvider(new Faker\Provider\Ecommerce($faker));

        for($i = 0; $i < $count; $i++) {

            try{
                $name = $faker->categoryName();
                $parentCategory = Mage::getModel('catalog/category')->load($parentId);

                $category = Mage::getModel('catalog/category');
                $category->setName($name);
                $category->setUrlKey('magefaker-' . $faker->categoryUrl($name));
                $category->setImage($faker->categoryImage);
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
     * Generates a product and product reviews
     *
     * @param $categories
     * @param $type
     * @return int
     */
    private function insertProduct($categories, $type = 'simple'){

        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $faker = new Faker\Generator();
        $faker->addProvider(new Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\Ecommerce($faker));

        $rating_options = array(
            1 => array(1, 2, 3, 4, 5),
            2 => array(6, 7, 8, 9, 10),
            3 => array(11, 12, 13, 14, 15)
        );

        $product = Mage::getModel('catalog/product');

        $name   = $faker->productName;
        $sku    = $faker->sku($name);
        $price  = $faker->price;

        try {
            $product
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(4) // default set
                ->setTypeId($type)
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

            $reviewCount = mt_rand(0, 10);

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
                    $stars = mt_rand(1, 3);

                    Mage::getModel('rating/rating')
                        ->setRatingId($rating_id)
                        ->setReviewId($review->getId())
                        ->addOptionVote($option_ids[$stars], $new_productId);
                }

                $review->aggregate();
            }

            return $new_productId;

        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * Insert a new attribute
     *
     * @param $code
     * @param $input
     * @throws Exception
     */
    private function insertAttribute($code, $input){

        $_attribute_data = array(
            'attribute_code' => $code,
            'is_global' => '1',
            'frontend_input' => $input,
            'default_value' => 'white',
            'is_unique' => '0',
            'is_required' => '0',
            'is_configurable' => '1',
            'is_filterable' => '1',
            'is_searchable' => '1',
            'is_filterable_in_search' => '1',
            'is_visible_in_advanced_search' => '0',
            'is_comparable' => '0',
            'is_used_for_price_rules' => '0',
            'is_wysiwyg_enabled' => '0',
            'is_html_allowed_on_front' => '1',
            'is_visible_on_front' => '0',
            'used_in_product_listing' => '0',
            'used_for_sort_by' => '0',
            'frontend_label' => array('Fake color')
        );

        $attr_model = Mage::getModel('catalog/resource_eav_attribute');

        $_attribute_data['backend_type'] = $attr_model->getBackendTypeByInput('select');

        $attr_model->addData($_attribute_data);

        $attr_model->setEntityTypeId(Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId());
        $attr_model->setIsUserDefined(1);

        $attr_model->save();
    }
}