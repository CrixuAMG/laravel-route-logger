<?php

namespace CrixuAMG\RouteLogger\Converters;

class FirstXConverter extends AbstractConverter
{
    const STARTS_STRING = 'first:';

    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function convert($value, $rule = null)
    {
        if (is_string($value) || is_numeric($value)) {
            return substr($value, 0, (int)str_after($rule, static::STARTS_STRING));
        }

        if (is_array($value)) {
            return array_slice($value, 0, (int)str_after($rule, static::STARTS_STRING));
        }

        throw new \InvalidArgumentException(sprintf(
            'Type %s is currently not supported!',
            gettype($value)
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
        return starts_with($value, static::STARTS_STRING);
    }
}
