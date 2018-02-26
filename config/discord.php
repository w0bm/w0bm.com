<?php
return [
    'enabled' => true,
    'webhookurl' => env('DISCORD_WEBHOOK', false),
    'message' => ':play_pause: <USER> uploaded a new webm: https://w0bm.com/<ID><NSFW>',
];