<?php

namespace CrixuAMG\RouteLogger\Converters;

use CrixuAMG\RouteLogger\Contracts\ConverterContract;

abstract class AbstractConverter implements ConverterContract
{
    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function convertIfPasses($value, $rule = null)
    {
        if ($this->passes($value, $rule)) {
            return $this->convert($value);
        }

        return $value;
    }
}
