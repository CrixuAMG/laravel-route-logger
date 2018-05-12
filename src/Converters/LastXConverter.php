<?php

namespace CrixuAMG\RouteLogger\Converters;

class LastXConverter extends AbstractConverter
{
    const STARTS_STRING = 'last:';

    /**
     * @param $rule
     * @param $value
     *
     * @return mixed
     */
    public function convert($value, $rule = null)
    {
        if (is_string($value) || is_numeric($value)) {
            return substr($value, -(strlen($value)), (int)str_after($rule, static::STARTS_STRING));
        }

        if (is_array($value)) {
            return array_slice($value, -(count($value)), (int)str_after($rule, static::STARTS_STRING));
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
        return starts_with($rule, static::STARTS_STRING);
    }
}
