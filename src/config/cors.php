<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => explode(',', env('CORS_ALLOWED_METHODS', 'GET, POST, PUT, DELETE, OPTIONS')),

    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost')),

    'allowed_origins_patterns' => [],

    'allowed_headers' => explode(',', env('CORS_ALLOWED_HEADERS', 'Content-Type, Authorization')),

    'exposed_headers' => [],

    'max_age' => env('CORS_MAX_AGE', 0),

    'supports_credentials' => env('CORS_SUPPORTS_CREDENTIALS', false),

];

// -- para facilitar os testes deixei esse codigo abaixo comentado. @@
// -- caso queriam testar a liberação do cors nativo, pode-se comentar o codigo a cima e 
// -- desconmentar esse aqui abaixo. tambem estou deixando um arquivo "cors-test.hmtl" para faciliar ainda mais os testes
// -- mas caso não queria testar dessa forma, simplesmente pode ser alterar o .env 

// return [

    // 'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // 'allowed_methods' => ['*'],

    // 'allowed_origins' => ['*'],

    // 'allowed_origins_patterns' => [],

    // 'allowed_headers' => ['*'],

    // 'exposed_headers' => [],

    // 'max_age' => 0,

    // 'supports_credentials' => false,

// ];


