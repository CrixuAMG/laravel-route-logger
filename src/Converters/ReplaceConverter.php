<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;

/**
 * Class ReplaceConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class ReplaceConverter implements ConverterContract
{
    /**
     *
     */
    const STARTS_STRING = 'replace:';

    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function test($value, $rule = null)
    {
        if (starts_with($value, static::STARTS_STRING)) {
            return $this->convert($value);
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
        return str_after($value, static::STARTS_STRING);
    }
}