<?php


namespace Knovators\Support\Traits;

use Illuminate\Support\Collection;


/**
 * Trait DestroyObject
 * @package Knovators\Support\Traits
 */
trait DestroyObject
{


    /**
     * @param $relations
     * @param $model
     * @param $moduleLabel
     * @return mixed
     */
    public function destroyModelObject($relations, $model, $moduleLabel)
    {
        foreach ($relations as $relation) {
            $model->load($relation);
            $dataCollection = $model->{$relation};
            if (($dataCollection instanceof Collection && $dataCollection->isNotEmpty()) ||
                ((!$dataCollection instanceof Collection) && (!is_null($dataCollection)))) {
                return $this->sendResponse(null,
                    __('messages.associated', [
                        'module' => $moduleLabel,
                        'related' => preg_replace('/(?<!\ )[A-Z]/', ' $0', ucwords($relation))
                    ]),
                    HTTPCode::UNPROCESSABLE_ENTITY);
            }
        }
        $model->delete();

        return $this->sendResponse(null, __('messages.deleted', ['module' => $moduleLabel]),
            HTTPCode::OK);
    }
}
