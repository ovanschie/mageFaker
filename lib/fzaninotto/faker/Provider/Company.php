<?php

namespace Faker\Provider;

class Company extends \Faker\Provider\Base
{
    protected static $formats = [
        '{{lastName}} {{companySuffix}}',
    ];

    protected static $companySuffix = ['Ltd'];

    /**
     * @example 'Acme Ltd'
     */
    public function company()
    {
        $format = static::randomElement(static::$formats);

        return $this->generator->parse($format);
    }

    /**
     * @example 'Ltd'
     */
    public static function companySuffix()
    {
        return static::randomElement(static::$companySuffix);
    }
}
