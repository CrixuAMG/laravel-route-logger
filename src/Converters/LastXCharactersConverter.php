<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;

class LastXCharactersConverter implements ConverterContract
{
    const STARTS_STRING = 'last:';

    /**
     * @param $rule
     * @param $value
     *
     * @return mixed
     */
    public function test($value, $rule = null)
    {
        if (starts_with($rule, static::STARTS_STRING)) {
            return $this->convert($value, $rule);
        }

        return $value;
    }

    /**
     * @param $rule
     * @param $value
     *
     * @return mixed
     */
    public function convert($value, $rule = null)
    {
        return substr($value, -(strlen($value)), (int)str_after($rule, 'last:'));
    }
}