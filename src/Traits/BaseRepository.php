<?php

namespace Knovators\Support\Traits;


use Prettus\Repository\Eloquent\BaseRepository as Repository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class BaseRepository
 * @package Knovators\Support\Traits
 */
abstract class BaseRepository extends Repository
{

    /**
     * @param       $field
     * @param null  $value
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function findBy($field, $value, $columns = ['*']) {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where($field, '=', $value)->first($columns);
        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($model);
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function find($id, $columns = ['*']) {
        $model = $this->model->find($id, $columns);
        $this->resetModel();
        return $this->parserResult($model);
    }



    /**
     * @param $value
     * @return mixed
     */
    public function findByCode($value) {
        $model = $this->model;
        if (is_array($value)) {
            $model = $model->whereIn('code', $value);
        } else {
            $model = $model->where('code', '=', $value);
        }

        return $model->first();
    }
}
