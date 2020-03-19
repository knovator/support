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
        if ($db === 'mongodb') {
            
            $data = $this->model->onlyTrashed()->where([$column => $value])->first();
            if ($data) {
                /** @var Model $data */
                return $data->update($input);
            } else {
                return $this->model->create($input);
            }
        }
        else{
            
            return $this->model->onlyTrashed()->updateOrCreate([$column => $value], $input);
        }
       
    }
}
