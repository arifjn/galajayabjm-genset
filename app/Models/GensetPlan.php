<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class GensetPlan extends Pivot
{
    public static function booted(): void
    {
        static::creating(function ($record) {
            $genset = Genset::find($record->genset_id);
            $genset->status_genset = 'rent';
            $genset->save();
        });

        static::deleting(function ($record) {
            $genset = Genset::find($record->genset_id);
            $genset->status_genset = 'ready';
            $genset->save();
        });
    }
}
