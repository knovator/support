<?php


namespace Knovators\Support\Traits;

use Illuminate\Support\Collection;
use Knovators\Support\Helpers\HTTPCode;


/**
 * Trait DestroyObject
 * @package Knovators\Support\Traits
 */
trait DestroyObject
{


    /**
     * @param      $relations
     * @param      $model
     * @param      $moduleLabel
     * @param bool $moduleName
     * @return mixed
     */
    public function destroyModelObject($relations, $model, $moduleLabel, $moduleName = false) {
        foreach ($relations as $relation) {
            $model->load($relation);
            $dataCollection = $model->{$relation};
            if (($dataCollection instanceof Collection && $dataCollection->isNotEmpty()) ||
                ((!$dataCollection instanceof Collection) && (!is_null($dataCollection)))) {
                return $this->sendResponse(null,
                    __('messages.associated', [
                        'module'  => $moduleLabel,
                        'related' => preg_replace('/(?<!\ )[A-Z]/', ' $0', ucwords($relation))
                    ]),
                    HTTPCode::UNPROCESSABLE_ENTITY);
            }
        }
        $model->delete();


        $moduleName = $moduleName ? $moduleName . '::' : '';

        return $this->sendResponse(null, trans($moduleName . 'messages.deleted', [
            'module' =>
                $moduleLabel
        ]),
            HTTPCode::OK);
    }
}
