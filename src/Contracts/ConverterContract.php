<?php

namespace CrixuAMG\RouteLogger\Contracts;

/**
 * Interface ConverterContract
 *
 * @package CrixuAMG\RouteLogger\Contracts
 */
interface ConverterContract
{
    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function convertIfPasses($value, $rule = null);

    /**
     * @param      $value
     * @param null $rule
     *
     * @return mixed
     */
    public function convert($value, $rule = null);

    /**
     * @param      $value
     * @param null $rule
     *
     * @return bool
     */
    public function passes($value, $rule = null): bool;
}
