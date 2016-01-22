<?php

namespace Faker\Provider;

class MageFaker extends \Faker\Provider\Base {

    /**
     * @var array
     */
    protected static $fashionNames = array(
        "French Cuff Cotton Twill Oxford","Slim fit Dobby Oxford Shirt","Plaid Cotton Shirt","Sullivan Sport Coat","Linen Blazer","Stretch Cotton Blazer","Chelsea Tee",
        "Merino V-neck Pullover Sweater","Lexington Cardigan Sweater","Core Striped Sport Shirt","Bowery Chino Pants","The Essential Boot Cut Jean","Flat Front Trouser",
        "NoLIta Cami","Black NoLIta Cami","Tori Tank","Delancy Cardigan Sweater","Ludlow Oxford Top","Elizabeth Knit Top","Essex Pencil Skirt","Racer Back Maxi Dress","Sheath",
        "Convertible Dress","Park Avenue Pleat Front Trousers","Aviator Sunglasses","Jackie O Round Sunglasses","Retro Chic Eyeglasses","Barclay d'Orsay pump, Nude","Ann Ankle Boot",
        "Hana Flat, Charcoal","Dorian Perforated Oxford","Wingtip Cognac Oxford","Suede Loafer, Navy","Isla Crossbody Handbag","Florentine Satchel Handbag","Flatiron Tablet Sleeve",
        "Broad St. Flapover Briefcase","Houston Travel Wallet","Roller Suitcase","Classic Hardshell Suitcase","Classic Hardshell Suitcase","Body Wash with Lemon Flower Extract and Aloe Vera",
        "Bath Minerals and Salt","Shea Enfused Hydrating Body Lotion","Titian Raw Silk Pillow","Shay Printed Pillow","Carnegie Alpaca Throw","Park Row Throw","Gramercy Throw","Herald Glass Vase",
        "Modern Murray Ceramic Vase","Stone Salt and Pepper Shakers","Fragrance Diffuser Reeds","Geometric Candle Holders","Ludlow Sheath Dress","Lafayette Convertible Dress","TriBeCa Skinny Jean",
        "DUMBO Boyfriend Jean","Classic Hardshell Suitcase","Luggage Set","Vase Set","Olvidalo by Brownout","Alice in Wonderland","Khaki Bowery Chino Pants","Core Striped Sport Shirt-Indigo",
        "Classic Hardshell Suitcase","Pearl Strand Necklace","Blue Horizons Bracelets","Pearl Stud Earrings","Swing Time Earrings","Silver Desert Necklace","Swiss Movement Sports Watch",
        "Pearl Necklace Set","Around the World in 80 Days","Thomas Overcoat","Draper Suit Coat","Lincoln Blazer","Bushwick Skinny Jean","Draper Pant","Olive Bushwick Skinny Jean","Avery Oxford Shirt",
        "Slim-fit Dobby Oxford Shirt","Carroll Check Dress Shirt","Clark Dress Shirt","Striped Crew Tee","Oatmeal Henley Tee","Henley Tee","Villa Bermuda Shorts","Cornelia Skirt","Grand Slim Straight Jean",
        "Hester Ankle Pant","Angela Wrap Dress","Jane Dress","Jacqueline Medallion Dress","Ludlow Seersucker Top","Gans Trench Coat","Sheri Collar Shirt","Charcoal Sheri Collar Shirt","Milli Cardigan",
        "Stretch Cotton Camisole","Noa Sheer Blouse","Brooklyn Jean Jacket","Mercer Loafer","Broad St Saddle Shoes","Empire Oxford","Lenox Boot","Studio Dress Shoe","Carnegie Sneaker","Hudson Snakeskin Pump",
        "Prima Pump","Plaza Platform","Annie Pump","Broadway Pump","Ellis Flat","Yuca Sneaker","Black Nolita Cami","NoLIta Cami-Pink","Black Nolita Cami-Black"
    );

    /**
     * @var array
     */
    protected static $fashionCategories = array(
        "Tops & Blouses",
        "Dresses & Skirts",
        "Shirts",
        "Tees, Knits and Polos",
        "Pants",
        "Jeans",
        "Blazers",
        "Accessories",
        "Eyewear",
        "Shoes",
        "Sneakers",
        "Bags & Luggage",
        "Sale",
        "Women",
        "Men",
        "VIP"
    );

    // product

    /**
     * @return mixed
     */
    public function productName(){
        return static::randomElement(static::$fashionNames);
    }

    /**
     * @return string
     */
    public function productImage(){
        return 'media/mageFaker/product/' . mt_rand(1, 30) . '.jpg';
    }

    /**
     * @return string
     */
    public function price(){
        return (int) mt_rand(1, 999) . '.' . round(mt_rand(0, 99), 2, PHP_ROUND_HALF_EVEN);
    }

    /**
     * @return string
     */
    public function sku(){
        return 'magefaker-' . uniqid();
    }

    /**
     * @return string
     */
    public function weight(){
        return (int) mt_rand(1, 999) . '.0000';
    }

    /**
     * @return string
     */
    public function shortDescription(){
        return $this->generator->paragraph(8);
    }

    /**
     * @return string
     */
    public function description(){
        $paragraph = '';
        for($i = 0; $i < 4; $i++){
            $paragraph .= '<p>' . $this->generator->paragraph(8) . '</p>';
        }
        return $paragraph;
    }

    /**
     * @return string
     */
    public function metaKeys(){
        $words = $this->generator->words(4);
        return implode(', ', $words);
    }

    /**
     * @return string
     */
    public function metaDescription(){
        return $this->generator->paragraph(4);
    }
    
    /**
     * @return mixed
     */
    public function categoryName(){
        return static::randomElement(static::$fashionCategories);
    }

    /**
     * @return string
     */
    public function categoryImage(){
        return '../../../media/mageFaker/category/' . mt_rand(1, 5) . '.jpg';
    }

    /**
     * @param $name
     * @return string
     */
    public function categoryUrl($name){
        return $name . '-' . uniqid();
    }
}