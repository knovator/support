<?php


namespace Knovators\Support\Routing;

/**
 * Class     RouteRegister
 *
 * @package  Knovators\Support\Laravel
 *
 * @method  \Knovators\Support\Routing\RouteRegister  as(string $name)
 * @method  \Knovators\Support\Routing\RouteRegister  domain(string $domain)
 * @method  \Knovators\Support\Routing\RouteRegister  middleware(string $middleware)
 * @method  \Knovators\Support\Routing\RouteRegister  name(string $name)
 * @method  \Knovators\Support\Routing\RouteRegister  namespace(string $namespace)
 * @method  \Knovators\Support\Routing\RouteRegister  prefix(string $prefix)
 * @method  void                                       group(...$mixed)
 *
 * @method  \Illuminate\Routing\Route  get(string $uri, \Closure|array|string|null $action = null)
 * @method  \Illuminate\Routing\Route  post(string $uri, \Closure|array|string|null $action = null)
 * @method  \Illuminate\Routing\Route  put(string $uri, \Closure|array|string|null $action = null)
 * @method  \Illuminate\Routing\Route  patch(string $uri, \Closure|array|string|null $action = null)
 * @method  \Illuminate\Routing\Route  delete(string $uri, \Closure|array|string|null $action = null)
 * @method  \Illuminate\Routing\Route  options(string $uri, \Closure|array|string|null $action = null)
 * @method  \Illuminate\Routing\Route  any(string $uri, \Closure|array|string|null $action = null)
 * @method  \Illuminate\Routing\Route  match(array|string $methods, string $uri, \Closure|array|string|null $action = null)
 *
 * @method  void  resource(string $name, string $controller, array $options = [])
 * @method  void  resources(array $resources)
 *
 * @method  void  pattern(string $key, string $pattern)
 * @method  void  patterns(array $patterns)
 *
 * @method  void  model(string $key, string $class, \Closure|null $callback = null)
 * @method  void  bind(string $key, string|\Closure $binder)
 *
 * @method  void  aliasMiddleware(string $name, string $class)
 */
abstract class RouteRegister
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register and map routes.
     */
    public static function register()
    {
        (new static)->map();
    }

    /**
     * Map the routes for the application.
     */
    abstract public function map();

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Call the router method.
     *
     * @param  string  $name
     * @param  array   $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return app('router')->$name(...$arguments);
    }
}
