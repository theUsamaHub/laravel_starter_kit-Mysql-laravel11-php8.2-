<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            ActivityLog::log('created', $model, null, $model->toArray());
        });

        static::updated(function (Model $model) {
            $dirty = $model->getDirty();
            if (!empty($dirty)) {
                $old = array_intersect_key($model->getOriginal(), $dirty);
                ActivityLog::log('updated', $model, $old, $dirty);
            }
        });

        static::deleted(function (Model $model) {
            ActivityLog::log('deleted', $model, $model->toArray(), null);
        });
    }
}
