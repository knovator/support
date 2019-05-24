<?php namespace Knovators\Support\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * Class     EventServiceProvider
 *
 * @package  Knovators\Support\Laravel\Providers

 */
abstract class EventServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the application's event listeners.
     */
    public function boot()
    {
        foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            Event::subscribe($subscriber);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }
}
