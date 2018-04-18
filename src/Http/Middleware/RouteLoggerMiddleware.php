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

            if (!empty($data)) {
                $recentlyCreated = RequestLog::where($data)
                    ->where(
                        'updated_at',
                        '>',
                        (new \DateTime())->modify(
                            sprintf('-%u hours', config('route-logger.hours_between_records'))
                        )->format('Y-m-d H:i:s')
                    )
                    ->first();

                if ($recentlyCreated) {
                    return $response;
                }
            }

            $data['uri']        = $request->getPathInfo();
            $data['name']       = $request->route()->getName();
            $data['method']     = $request->getMethod();
            $data['parameters'] = $request->request->all();
            $data['query']      = $request->query();

            RequestLog::create($data);
        }

        return $response;
    }
}