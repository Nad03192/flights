<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    public static function bootAuditable()
    {
        static::updating(function ($model) {
            $original = $model->getOriginal();
            $changes = $model->getDirty();

            // If there are no actual changes, skip
            if (empty($changes)) {
                return;
            }

            AuditLog::create([
                'auditable_type' => get_class($model),
                'auditable_id'   => $model->getKey(),
                'event'          => 'updated',
                'user_id'        => Auth::id(),
                'old_values'     => json_encode($original),
                'new_values'     => json_encode($changes),
                
            ]);
        });

        static::created(function ($model) {
            AuditLog::create([
                'auditable_type' => get_class($model),
                'auditable_id'   => $model->getKey(),
                'event'          => 'created',
                'user_id'        => Auth::id(),
                'old_values'     => null,
                'new_values'     => json_encode($model->getAttributes()),
                'ip_address'     => Request::ip(),
            ]);
        });

        static::deleted(function ($model) {
            AuditLog::create([
                'auditable_type' => get_class($model),
                'auditable_id'   => $model->getKey(),
                'event'          => 'deleted',
                'user_id'        => Auth::id(),
                'old_values'     => json_encode($model->getOriginal()),
                'new_values'     => null,
                'ip_address'     => Request::ip(),
            ]);
        });
    }
}
