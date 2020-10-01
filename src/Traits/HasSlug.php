<?php


namespace Knovators\Support\Traits;
use Illuminate\Support\Str;

/**
 * Trait HasSlugMaker
 * @package Knovators\Support\Traits
 */
trait HasSlug
{

    /**
     * Save the model to the database.
     *
     * @param  array $options
     * @return bool
     */
    public function save(array $options = []) {
        parent::save($options);
        $slugColumn = $this->slugColumn;
        if (!$this->$slugColumn) {
            $this->$slugColumn = $this->getSlug();
        } elseif ($this->isSlugifyColumnsChanged()) {
            $this->$slugColumn = $this->getSlug();
        }

        return parent::save($options);
    }

    /**
     * @return string
     */
    private function getSlug() {
        $slug = '';
        foreach ($this->slugifyColumns as $column) {
            $slug .= '-' . $this->$column;
        }

        return Str::slug($slug);
    }

    /**
     * @return bool
     */
    private function isSlugifyColumnsChanged() {
        $changed = $this->getDirty();
        foreach ($this->slugifyColumns as $column) {
            if (isset($changed[$column])) {
                return true;
            }
        }

        return false;
    }


}
