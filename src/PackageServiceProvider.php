<?php namespace Knovators\Support;

use Knovators\Support\Exceptions\PackageException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use ReflectionClass;

/**
 * Class     PackageServiceProvider
 *
 * @package  Knovators\Support\Laravel
 */
abstract class PackageServiceProvider extends ServiceProvider
{


    protected $ds = DIRECTORY_SEPARATOR;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor = 'knovators';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = '';

    /**
     * Package base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     */
    protected $multiConfigs = false;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->basePath = $this->resolveBasePath();
    }

    /**
     * Resolve the base path of the package.
     *
     * @return string
     */
    protected function resolveBasePath()
    {
        return dirname(
            (new ReflectionClass($this))->getFileName(), 2
        );
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get config folder.
     *
     * @return string
     */
    protected function getConfigFolder()
    {
        return realpath($this->getBasePath().$this->ds.'config');
    }

    /**
     * Get config key.
     *
     * @return string
     */
    protected function getConfigKey()
    {
        return Str::slug($this->package);
    }

    /**
     * Get config file path.
     *
     * @return string
     */
    protected function getConfigFile()
    {
        return $this->getConfigFolder().$this->ds."{$this->package}.php";
    }

    /**
     * Get config file destination path.
     *
     * @return string
     */
    protected function getConfigFileDestination()
    {
        return config_path("{$this->package}.php");
    }

    /**
     * Get the base database path.
     *
     * @return string
     */
    protected function getDatabasePath()
    {
        return $this->getBasePath().$this->ds.'database';
    }

    /**
     * Get the migrations path.
     *
     * @return string
     */
    protected function getMigrationsPath()
    {
        return $this->getBasePath().$this->ds.'database'.$this->ds.'migrations';
    }

    /**
     * Get the base resources path.
     *
     * @return string
     */
    protected function getResourcesPath()
    {
        return $this->getBasePath().$this->ds.'resources';
    }

    /**
     * Get the base views path.
     *
     * @return string
     */
    protected function getViewsPath()
    {
        return $this->getResourcesPath().$this->ds.'views';
    }

    /**
     * Get the destination views path.
     *
     * @return string
     */
    protected function getViewsDestinationPath()
    {
        return resource_path('views'.$this->ds.'vendor'.$this->ds.$this->package);
    }

    /**
     * Get the translations path.
     *
     * @return string
     */
    protected function getTranslationsPath()
    {
        return $this->getResourcesPath().$this->ds.'lang';
    }

    /**
     * Get the destination views path.
     *
     * @return string
     */
    protected function getTranslationsDestinationPath()
    {
        return resource_path('lang'.$this->ds.'vendor'.$this->ds.$this->package);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     * @throws PackageException
     */
    public function register()
    {
        parent::register();

        $this->checkPackageName();
    }

    /* -----------------------------------------------------------------
     |  Package Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register configs.
     *
     * @param  string  $separator
     */
    protected function registerConfig($separator = '.')
    {

        $this->multiConfigs
            ? $this->registerMultipleConfigs($separator)
            : $this->mergeConfigFrom($this->getConfigFile(), $this->getConfigKey());
    }

    /**
     * Register all package configs.
     *
     * @param  string  $separator
     */
    private function registerMultipleConfigs($separator = '.')
    {
        foreach (glob($this->getConfigFolder().'/*.php') as $configPath) {
            $this->mergeConfigFrom(
                $configPath, $this->getConfigKey().$separator.basename($configPath, '.php')
            );
        }
    }

    /**
     * Register commands service provider.
     *
     * @param  array $commands
     */
    protected function registerCommands($commands)
    {
        if ($this->app->runningInConsole())
            $this->commands($commands);
    }

    /**
     * Publish the config file.
     */
    protected function publishConfig()
    {
        $this->publishes([
            $this->getConfigFile() => $this->getConfigFileDestination()
        ], 'config');
    }

    /**
     * Publish the migration files.
     */
    protected function publishMigrations()
    {
        $this->publishes([
            $this->getMigrationsPath() => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Publish and load the views if $load argument is true.
     *
     * @param  bool  $load
     */
    protected function publishViews($load = true)
    {
        $this->publishes([
            $this->getViewsPath() => $this->getViewsDestinationPath()
        ], 'views');

        if ($load) $this->loadViews();
    }

    /**
     * Publish and load the translations if $load argument is true.
     *
     * @param  bool  $load
     */
    protected function publishTranslations($load = true)
    {
        $this->publishes([
            $this->getTranslationsPath() => $this->getTranslationsDestinationPath()
        ], 'lang');

        if ($load) $this->loadTranslations();
    }

    /**
     * Publish the factories.
     */
    protected function publishFactories()
    {
        $this->publishes([
            $this->getDatabasePath().$this->ds.'factories' => database_path('factories'),
        ], 'factories');
    }

    /**
     * Publish all the package files.
     *
     * @param  bool  $load
     */
    protected function publishAll($load = true)
    {
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishViews($load);
        $this->publishTranslations($load);
        $this->publishFactories();
    }

    /**
     * Load the views files.
     */
    protected function loadViews()
    {
        $this->loadViewsFrom($this->getViewsPath(), $this->package);
    }

    /**
     * Load the translations files.
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom($this->getTranslationsPath(), $this->package);
    }

    /**
     * Load the migrations files.
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Check package name.
     *
     * @throws \Knovators\Support\Exceptions\PackageException
     */
    private function checkPackageName()
    {
        if (empty($this->vendor) || empty($this->package))
            throw new PackageException('You must specify the vendor/package name.');
    }
}
