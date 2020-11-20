<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Indicate Authenticated Middleware
    |--------------------------------------------------------------------------
    |
    | Here is where you can define the middleware that is required for your authentication.
    | This is important so we can display if a route requires authentication or not
    | within the API documentation.
    |
    */
    'auth_middleware' => [
        'auth:sanctum',
        'auth'
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes to be documented
    |--------------------------------------------------------------------------
    |
    | Define routes that need to be documented via the route middleware. By
    | default we document the routes/api.php You can enable the web option,
    | though it's not recommended since web routes typically return a view.
    */
    'routes' => 'api',

    /*
    |--------------------------------------------------------------------------
    | Path to Controllers
    |--------------------------------------------------------------------------
    |
    | Define the path to your controllers so we can properly namespace/group
    | their subsequent endpoints.
    */
    'controller_path' => 'App\Http\Controllers',

    /*
    |--------------------------------------------------------------------------
    | External Pages
    |--------------------------------------------------------------------------
    |
    | Define extra pages you want to have in your documentation. Common examples
    | include an overview page or auth page. You will need to create the pages
    | within the resources/docs/1.x/ directory.
    */
    'pages' => [
        'Overview'
    ]
];