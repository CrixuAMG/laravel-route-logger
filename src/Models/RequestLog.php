<?php

namespace CrixuAMG\RouteLogger\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'parameters' => 'object',
        'query'      => 'object',
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
    ];
    /**
     * @var string
     */
    protected $table = 'request_logs';

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
        'new_password',
        'new_password_confirmation',
    ];

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
