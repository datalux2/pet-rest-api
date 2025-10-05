<?php

return [
    
    'paths' => ['api/*', '*'],  // dodaj '*' jeśli nie masz /api
    
    'allowed_methods' => ['*'],
    
    'allowed_origins' => ['*'], // dla developmentu
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => false,
    
];
