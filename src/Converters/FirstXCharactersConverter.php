<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;

class FirstXCharactersConverter implements ConverterContract
{
    const STARTS_STRING = 'first:';

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
        return substr($value, 0, (int)str_after($rule, 'first:'));
    }
}