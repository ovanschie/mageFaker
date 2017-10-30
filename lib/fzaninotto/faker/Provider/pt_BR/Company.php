<?php

namespace Faker\Provider\pt_BR;

class Company extends \Faker\Provider\Company
{
    protected static $formats = [
        '{{lastName}} {{companySuffix}}',
        '{{lastName}}-{{lastName}}',
        '{{lastName}} e {{lastName}}',
        '{{lastName}} de {{lastName}}',
        '{{lastName}}, {{lastName}} e {{lastName}}',
    ];

    protected static $companySuffix = ['e Filho', 'e Filha', 'e Filhos', 'e Associados', 'e Flia.', 'SRL', 'SA', 'S. de H.'];
}
