<?php

namespace CrixuAMG\RouteLogger\Http\Middleware;

use CrixuAMG\RouteLogger\Models\RequestLog;

class RouteLoggerMiddleware
{
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
        $response = $next($request);

        if (config('route-logger.log_requests')) {
            $data = [];

            if (config('route-logger.track_ip')) {
                $data['ip'] = $request->ip();
            }
            $userId = auth()->check() ? auth()->user()->id : null;
            if (!empty($userId)) {
                $data['user_id'] = $userId;
            }

            // Create the new log
            RequestLog::create(
                array_merge(
                    $data,
                    [
                        // Build up the data
                        'uri' => $request->getPathInfo(),
                        'name' => $request->route()->getName(),
                        'method' => $request->getMethod(),
                        'query' => $request->query(),
                        'parameters' => $request->request->except(
                            // Get all fields that should never be saved to the database
                            RequestLog::getIllegalFields()
                        ),
                    ]
                )
            );
        }

        return $response;
    }
}