<?php

return [
    /**
     * Enable or disable route logging
     */
    'log_requests'          => (bool)env('APP_LOG_REQUESTS', true),

    /**
     * Whether the IP address should be saved to the database or not
     */
    'track_ip'              => (bool)env('APP_LOG_IP', true),

    /**
     * Data that should not be logged
     */
    'log_except'            => [],
];
