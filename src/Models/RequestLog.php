<?php

namespace CrixuAMG\RouteLogger\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    /**
     * The attributes that are illegal to save to the database.
     *
     * @var array
     */
    private static $illegalFields = [
        'client_id',
        'client_secret',
        'password',
        'password_confirmation',
    ];
    /**
     * @var array
     */
    protected $casts = [
        'parameters' => 'object',
        'query'      => 'object',
        'extra_data'      => 'object',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'uri',
        'method',
        'parameters',
        'query',
        'ip',
        'query_count',
        'response_time',
        'extra_data',
    ];
    /**
     * @var string
     */
    protected $table = 'request_logs';

    /**
     * @return array;
     */
    public static function getIllegalFields(): array
    {
        // Merge the data in the illegal fields array above with the configurable array in the config file
        return array_merge(
            (array)config('route-logger.log_except'),
            self::$illegalFields
        );
    }
}
