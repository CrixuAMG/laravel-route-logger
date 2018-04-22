<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;

class ClosureConverter implements ConverterContract
{
    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function test($value, $rule = null)
    {
        return $this->convert($value, $rule);
    }

    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function convert($value, $rule = null)
    {
        /** @var $rule \Closure */
        return $rule($value);
    }
}