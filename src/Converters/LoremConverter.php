<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;
use Faker\Factory as Faker;

/**
 * Class LoremConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class LoremConverter implements ConverterContract
{
    /**
     *
     */
    const INDENTIFIER = 'lorem';
    /**
     * @var Faker
     */
    private $faker;

    /**
     * LoremConverter constructor.
     */
    public function __construct()
    {
        $this->faker = new Faker();
    }

    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function test($value, $rule = null)
    {
        if ($rule === static::INDENTIFIER) {
            return $this->convert($value, $rule);
        }

        return $value;
    }

    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function convert($value, $rule = null)
    {
        dd($value, $rule, $this);
    }
}