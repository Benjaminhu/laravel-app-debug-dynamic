# Dynamic enable APP_DEBUG via COOKIE & IP

## Installation

You can install the package via composer:

```shell
$ composer require benjaminhu/laravel-app-debug-dynamic
```

## Usage

Simply register the newly created class in your (top of) middleware stack.

```php
// app/Http/Kernel.php
class Kernel extends HttpKernel
{
    protected $middleware = [
        \Benjaminhu\LaravelAppDebugDynamic\AppDebugDynamicMiddleware::class,
        // ...
    ];
    // ...
}
```

Publish config:
```shell
$ php artisan vendor:publish --provider="Benjaminhu\LaravelAppDebugDynamic\AppDebugDynamicServiceProvider"
```

Setup .env (remember: in **production** mode alway set: `APP_DEBUG=false`!):
```dotenv
# ...
APP_DEBUG=false
APP_DEBUG_DYNAMIC_COOKIE_NAME=<CHOOSE COOKIE NAME>
APP_DEBUG_DYNAMIC_COOKIE_SECRET=<CHOOSE COOKIE SECRET>
# optional
# APP_DEBUG_DYNAMIC_ALLOWED_IPS=<LIST, OF, ALLOWED, IP, ADDRESSES>
# ...
```

## Testing

```shell
$ composer test
```
