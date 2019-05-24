<?php

namespace Knovators\Support\Bases;

use Knovators\Support\Exceptions\MissingPolicyException;
use Illuminate\Support\Str;

/**
 * Class     Policy
 *
 * @package  Knovators\Support\Bases
 */
abstract class Policy
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the policies.
     *
     * @return array
     */
    public static function policies()
    {
        $abilities = array_values(
            (new \ReflectionClass($instance = new static))->getConstants()
        );

        return array_map(function ($constant) use ($instance) {
            $method = Str::camel(last(explode('.', $constant)).'Policy');

            if ( ! method_exists($instance, $method))
                throw new MissingPolicyException("Missing policy [$method] method in ".get_class($instance).".");

            return $method;
        }, array_combine($abilities, $abilities));
    }
}
