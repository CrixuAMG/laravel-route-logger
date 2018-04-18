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
    ];
    /**
     * @var string 
     */
    protected $table = 'request_logs';
}
