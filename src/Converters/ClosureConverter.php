<?php

namespace CrixuAMG\RouteLogger\Converters;

class ClosureConverter extends AbstractConverter
{
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

    /**
     * @param      $value
     * @param null $rule
     *
     * @return bool
     */
    public function passes($value, $rule = null): bool
    {
        return $value instanceof \Closure;
    }
}
