<?php

namespace CrixuAMG\RouteLogger\Converters;

/**
 * Class ReplaceConverter
 *
 * @package CrixuAMG\RouteLogger\Converters
 */
class ReplaceConverter extends AbstractConverter
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
    public function convert($value, $rule = null)
    {
        return str_after($value, static::STARTS_STRING);
    }

    /**
     * @param      $value
     * @param null $rule
     *
     * @return bool
     */
    public function passes($value, $rule = null): bool
    {
        return starts_with($value, static::STARTS_STRING);
    }
}
