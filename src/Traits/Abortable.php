<?php namespace Knovators\Support\Traits;

/**
 * Trait     Abortable
 *
 * @package  Knovators\Support\Traits

 *
 * @deprecated Use directly the abort() helper function instead.
 */
trait Abortable
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Throw Page not found [404].
     *
     * @param  string  $message
     * @param  array   $headers
     */
    protected static function pageNotFound($message = 'Page not Found', array $headers = [])
    {
        return abort(404, $message, $headers);
    }

    /**
     * Throw AccessNotAllowed [403].
     *
     * @param  string  $message
     * @param  array   $headers
     */
    protected static function accessNotAllowed($message = 'Access denied !', array $headers = [])
    {
        return abort(403, $message, $headers);
    }
}
