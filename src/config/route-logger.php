<?php

return [
    'log_requests'          => (bool)env('APP_LOG_REQUESTS', true),

    'track_ip'              => (bool)env('APP_LOG_IP', true),

    'hours_between_records' => (int)env('APP_LOG_HOURS_BETWEEN', 1),
];
