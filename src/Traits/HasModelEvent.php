<?php


namespace Knovators\Support\Traits;

use Illuminate\Database\Eloquent\Model;


/**
 * Trait HasModelEvent
 * @package Knovators\Support\Traits
 */
trait HasModelEvent
{

    public static function boot() {
        parent::boot();
        self::creatingEvent();
        self::deletedEvent();
    }

    public static function creatingEvent() {
        static::creating(function (Model $model) {
            $model->created_by = isset(auth()->user()->id) ? auth()->user()->id : null;
        });
    }

    public static function deletedEvent() {
        static::deleted(function (Model $model) {
            $model->deleted_by = isset(auth()->user()->id) ? auth()->user()->id : null;
            $model->save();
        });
    }


    public static function updatingEvent() {
        static::updating(function (Model $model) {
            $model->updated_by = isset(auth()->user()->id) ? auth()->user()->id : null;
        });

    }

}
