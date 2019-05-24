<?php namespace Knovators\Support\Http;

use Knovators\Support\Traits\Abortable;
use Illuminate\Routing\Controller as IlluminateController;

/**
 * Class     Controller
 *
 * @package  Knovators\Support\Http

 */
abstract class Controller extends IlluminateController
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Abortable;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The view data.
     *
     * @var array
     */
    protected $data = [];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->setCurrentPage();
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get data.
     *
     * @return array
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * Set view data.
     *
     * @param  string|array  $name
     * @param  mixed         $value
     *
     * @return self
     */
    protected function setData($name, $value = null)
    {
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        }
        elseif (is_string($name)) {
            $this->data[$name] = $value;
        }

        return $this;
    }

    /**
     * Set the current page.
     *
     * @param  string  $page
     *
     * @return self
     */
    protected function setCurrentPage($page = '')
    {
        return $this->setData('current_page', $page);
    }
}
