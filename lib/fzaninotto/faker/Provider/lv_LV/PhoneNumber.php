<?php

namespace Faker\Provider\lv_LV;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '##-###-###',
        '##-######',
        '########',
        '+371 #######',
    ];
}
