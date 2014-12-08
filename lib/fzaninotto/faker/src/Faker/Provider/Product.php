<?php
namespace Faker\Provider;

class Product extends \Faker\Provider\Base
{
    public function productName(){
        return 'Sample product ';
    }

    public function price(){
        return (int) $this->numberBetween(1, 999) .'.'. $this->numberBetween(10,99);
    }

    public function sku($productName = ''){
        return strtolower(str_replace(' ', '-', $productName)) . '-' . uniqid();
    }

    public function weight(){
        return (int) $this->numberBetween(1, 999) . '.0000';
    }

    public function shortDescription(){
        return $this->generator->paragraph(6);
    }

    public function description(){
        $return = '';
        foreach($this->generator->paragraphs(3) as $paragraph){
            $return .= '<p>' . $paragraph . '</p>';
        }
        return $return;
    }
}