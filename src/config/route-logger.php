<?php

return [
    /**
     * Enable or disable route logging
     */
    'log_requests'      => (bool)env('APP_LOG_REQUESTS', true),

    /**
     * Whether the user id should be saved to the database or not
     */
    'track_user'        => (bool)env('APP_LOG_USER', true),

    /**
     * Whether the IP address should be saved to the database or not
     */
    'track_ip'          => (bool)env('APP_LOG_IP', true),

    /**
     * Whether the query count should be saved to the database or not
     */
    'track_query_count' => (bool)env('APP_LOG_QUERY_COUNT', true),

    /**
     * Data that should not be logged
     */
    'log_except'        => [],

    /**
     *
     */
    'filter_fields'     => [],

    /**
     * When the value of this element is a callback, the request will be passed to it, and any extra data can be retrieved
     * from it to increase the amount of valuable information in the database
     */
    'request_callback' => null,
//    'request_callback' => function ($request) {
//      //
//    }
];
