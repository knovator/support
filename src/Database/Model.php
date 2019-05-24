<?php

namespace Knovators\Support\Database;

use Knovators\Support\Traits\PrefixedModel;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class     Model
 *
 * @package  Knovators\Support\Laravel
 */
abstract class Model extends Eloquent
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use PrefixedModel;
}
