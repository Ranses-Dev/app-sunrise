<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'smarty' => [
        'base_url' => env('SMARTY_API_BASE_URL', 'https://us-street.api.smartystreets.com/street-address'),
        'auth_id'  => env('SMARTY_API_AUTH_ID'),
        'auth_token' => env('SMARTY_API_AUTH_TOKEN'),
        'timeout' => env('SMARTY_API_TIMEOUT'),
    ],
    'programs' => [
        'howpa_id' => env('PROGRAM_HOWPA_ID'),
        'inspection_id' => env('PROGRAM_INSPECTIONS_ID'),
        'meals_id' => env('PROGRAM_MEALS_ID'),
        'rental_id' => env('PROGRAM_RENTAL_ID'),
    ],
    'program_branches' => [
        'howpas_id' => env('PROGRAM_BRANCH_HOWPAS_ID'),
    ]
];
