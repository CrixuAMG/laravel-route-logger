<?php

namespace CrixuAMG\RouteLogger\Converters;

/**
 * Class ApproximateConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class ApproximateConverter extends AbstractConverter
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
    public function convert($value, $rule = null)
    {
        $length     = strlen($value);
        $multiplier = $this->multiplier;

        return sprintf('|approximate: %u', random_int(
            $length / $multiplier,
            $length * $multiplier
        ));
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
