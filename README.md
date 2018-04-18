# Laravel Route Logger

## Installation
First, run `composer require crixuamg/laravel-route-logger` in your terminal.
Then, run `php vendor:publish --tag=CrixuAMG\RouteLogger\RouteLoggerServiceProvider` to publish the config and migration.
Then run `php artisan migrate` and the table will be created in your database.
The last step is to register the middleware in `app/Htpp/Middleware/Kernel.php`: `CrixuAMG\RouteLogger\Http\Middleware\RouteLoggerMiddleware::class,`

## Usage
After installing the package using the steps above all wil be ready to use. Try out a couple of routes and view the data in your database viewer of choice!