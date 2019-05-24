<?php


namespace Knovators\Support\Traits;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Parent_;


/**
 * Trait HasModelEvent
 * @package App\Modules\Support
 */
trait HasModelEvent
{

    public static function boot() {
        parent::boot();
        self::creatingEvent();
        self::deletingEvent();
    }

    public static function creatingEvent() {
        static::creating(function (Model $model) {
            $model->created_by = isset(auth()->user()->id) ? auth()->user()->id : null;
        });
    }

    public static function deletingEvent() {
        static::deleting(function (Model $model) {
            $model->deleted_by = isset(auth()->user()->id) ? auth()->user()->id : null;
        });
    }


    public static function updatedEvent() {
        static::updating(function (Model $model) {
            $model->updated_by = isset(auth()->user()->id) ? auth()->user()->id : null;
        });

    }

}
