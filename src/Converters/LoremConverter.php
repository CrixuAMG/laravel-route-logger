<?php

namespace CrixuAMG\RouteLogger\Converters;

use Faker\Factory as Faker;

/**
 * Class LoremConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class LoremConverter extends AbstractConverter
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
    public function convertIfPasses($value, $rule = null)
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

    /**
     * @param      $value
     * @param null $rule
     *
     * @return bool
     */
    public function passes($value, $rule = null): bool
    {
        return $rule === static::INDENTIFIER;
    }
}
