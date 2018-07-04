<?php

namespace CrixuAMG\RouteLogger\Http\Middleware;

use CrixuAMG\RouteLogger\Converters\ApproximateConverter;
use CrixuAMG\RouteLogger\Converters\ClosureConverter;
use CrixuAMG\RouteLogger\Converters\CountConverter;
use CrixuAMG\RouteLogger\Converters\FirstXConverter;
use CrixuAMG\RouteLogger\Converters\LastXConverter;
use CrixuAMG\RouteLogger\Converters\LoremConverter;
use CrixuAMG\RouteLogger\Converters\ReplaceConverter;
use CrixuAMG\RouteLogger\Models\RequestLog;
use Illuminate\Support\Facades\DB;

/**
 * Class RouteLoggerMiddleware
 *
 * @package CrixuAMG\RouteLogger\Http\Middleware
 */
class RouteLoggerMiddleware
{
    /**
     * @var
     */
    private $requestLog;

    /**
     * @var array
     */
    private $startsConverters = [
        ReplaceConverter::class,
        FirstXConverter::class,
        LastXConverter::class,
    ];

    /**
     * @var string
     */
    private $closureConverter = ClosureConverter::class;

    /**
     * @var array
     */
    private $genericConverters = [
        LoremConverter::class,
        CountConverter::class,
        ApproximateConverter::class,
    ];

    /**
     * RouteLoggerMiddleware constructor.
     */
    public function __construct()
    {
        if (config('route-logger.track_query_count')) {
            DB::enableQueryLog();
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        // Prepare the data
        $response = $next($request);

        // Check whether or not we should log data
        if (config('route-logger.log_requests')) {
            $data = [];

            if (config('route-logger.track_ip')) {
                // Set the IP address if the value is set to true
                $data['ip'] = $request->ip();
            }
            if (config('route-logger.track_user')) {
                // Get the user id if the user is logged in
                $userId = auth()->check() ? auth()->user()->id : null;
                if (!empty($userId)) {
                    // Set the user_id if a user is logged in
                    $data['user_id'] = $userId;
                }
            }

            if (config('route-logger.track_query_count')) {
                $data['query_count'] = \count(DB::getQueryLog());
            }

            $data['response_time'] = round(microtime(true) - LARAVEL_START, 4);

            $routeQueryData = $request->query();
            $filteredQueryData = $this->filterData($routeQueryData);

            $filteredData = $this->filterData(
                array_diff(
                    $request->request->all(),
                    $routeQueryData
                )
            );

            // Create the new log
            $this->requestLog = RequestLog::create(
                array_merge(
                    $data,
                    [
                        // Build up the data
                        'uri'        => $request->getPathInfo(),
                        'name'       => optional($request->route())->getName(),
                        'method'     => $request->getMethod(),
                        'query'      => $filteredQueryData,
                        'parameters' => $filteredData,
                    ]
                )
            );
        }

        // Return the response
        return $response;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function filterData(array $data): array
    {
        // Get all fields that are illegal to save to the database
        $illegalFields = array_flip(RequestLog::getIllegalFields());
        $filterFields = (array)config('route-logger.filter_fields');

        foreach ($data as $name => $value) {
            $keyExists = array_key_exists($name, $filterFields);
            if (isset($illegalFields[$name]) && !$keyExists) {
                unset($data[$name]);

                continue;
            }

            if ($keyExists) {
                $valueToUse = null;
                $rules = $filterFields[$name];

                if (!is_array($rules)) {
                    $rules = explode('|', $rules);
                }

                foreach ($rules as $rule) {
                    $valueToUse = $this->useRule($rule, $value);
                }

                $data[$name] = $valueToUse;
            }
        }

        return $data;
    }

    /**
     * @param $rule
     * @param $value
     *
     * @return string
     */
    private function useRule($rule, $value): string
    {
        $valueToUse = $value;

        if (!($rule instanceof \Closure)) {
            foreach ($this->startsConverters as $converter) {
                $converter = new $converter;
                if (starts_with($rule, $converter::STARTS_STRING)) {
                    $valueToUse = $converter->convertIfPasses(
                        $valueToUse,
                        $rule
                    );
                }
            }

            foreach ($this->genericConverters as $converter) {
                $testedResult = (new $converter)->convertIfPasses($valueToUse, $rule);

                if ($testedResult !== $valueToUse) {
                    $valueToUse .= $testedResult;
                }
            }
        } else {
            $valueToUse = (new $this->closureConverter)->convertIfPasses($valueToUse, $rule);
        }

        return $valueToUse;
    }
}
