<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait IdentifiedByUuid
{


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->id = (string) Str::uuid();
        });
    }
}
