<?php

namespace CrixuAMG\RouteLogger\Http\Middleware;

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
            // Get the user id if the user is logged in
            $userId = auth()->check() ? auth()->user()->id : null;
            if (!empty($userId)) {
                // Set the user_id if a user is logged in
                $data['user_id'] = $userId;
            }

            $routeQueryData = $request->query();
            // Get all fields that are illegal to save to the database
            $illegalFields = RequestLog::getIllegalFields();

            // Create the new log
            $this->requestLog = RequestLog::create(
                array_merge(
                    $data,
                    [
                        // Build up the data
                        'uri'        => $request->getPathInfo(),
                        'name'       => $request->route()->getName(),
                        'method'     => $request->getMethod(),
                        'query'      => array_except(
                            $routeQueryData,
                            $illegalFields
                        ),
                        'parameters' => array_except(
                        // Filter all fields that should never be saved to the database
                            $request->request->all(),
                            $routeQueryData,
                            $illegalFields
                        ),
                    ]
                )
            );
        }

        // Return the response
        return $response;
    }

    /**
     * @param $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        if (config('route-logger.log_requests') && $this->requestLog) {
            $updateData = [];

            if (config('route-logger.track_query_count')) {
                $updateData['query_count'] = \count(DB::getQueryLog());
            }

            $updateData['response_time'] = microtime(true) - LARAVEL_START;

            $this->requestLog->update($updateData);
        }
    }
}