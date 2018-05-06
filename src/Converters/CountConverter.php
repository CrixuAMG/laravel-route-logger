<?php

namespace CrixuAMG\RouteLogger\Converters;

/**
 * Class CountConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class CountConverter extends AbstractConverter
{
    /**
     *
     */
    const INDENTIFIER = 'count';

    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function convert($value, $rule = null)
    {
        return sprintf('|count: %u', strlen($value));
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