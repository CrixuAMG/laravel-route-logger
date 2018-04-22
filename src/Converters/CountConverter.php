<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;

/**
 * Class CountConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class CountConverter implements ConverterContract
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
        return sprintf('|count: %u', strlen($value));
    }
}