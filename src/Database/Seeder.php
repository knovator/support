<?php

namespace Knovators\Support\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder as IlluminateSeeder;

/**
 * Class     Seeder
 *
 * @package  Knovators\Support\Bases
 */
abstract class Seeder extends IlluminateSeeder
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Seeder collection.
     *
     * @var array
     */
    protected $seeds = [];

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the database seeds.
     */
    public function run()
    {
        Eloquent::unguard();

        foreach ($this->seeds as $seed) {
            $this->call($seed);
        }

        Eloquent::reguard();
    }
}
