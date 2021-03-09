<?php

return [
    '/' => 'site/index',
    '/signup' => 'site/signup',

    '/chat' => 'site/chat',

    // api
    'GET /api' => 'api/default/index',

    'GET /api/message' => 'api/default/get',
    'POST /api/message' => 'api/default/send',
    'PUT /api/message/<id:[0-9]+>' => 'api/default/update',
    'DELETE /api/message/<id:[0-9]+>' => 'api/default/delete',

];
