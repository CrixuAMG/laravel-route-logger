<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;

/**
 * Class ApproximateConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class ApproximateConverter implements ConverterContract
{
    /**
     *
     */
    const INDENTIFIER = 'approximate';
    /**
     * @var int
     */
    private $multiplier = 1.2;

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
        $length = strlen($value);
        $multiplier = $this->multiplier;

        return sprintf('|approximate: %u', random_int(
            $length / $multiplier,
            $length * $multiplier
        ));
    }
}