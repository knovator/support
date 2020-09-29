<?php


namespace Knovators\Support\Traits;


/**
 * Trait StoreWithTrashedRecord
 * @package Knovators\Support\Traits
 */
trait StoreWithTrashedRecord
{

    /**
     * @param $column
     * @param $value
     * @param $input
     * @return
     */
    public function createOrUpdateTrashed($column, $value, $input) {
        $input['deleted_at'] = null;
        $db = config('authentication.db');
        $model = $this->model;
        $data = (clone $model)->onlyTrashed()->where([$column => $value])->first();
        if ($db && $db === 'mongodb') {
            if ($data) {
                $input['deleted_at'] = null;
                /** @var Model $data */
                $data->update($input);
            } else {
                $data = (clone $model)->create($input);
            }
        } else {
            $data = (clone $model)->onlyTrashed()->updateOrCreate([$column => $value], $input);
        }

        return $data;

    }
}
