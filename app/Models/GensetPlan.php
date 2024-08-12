<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class GensetPlan extends Pivot
{
    public static function booted(): void
    {
        static::creating(function ($record) {
            $plan = Plan::find($record->plan_id);

            if ($plan->jobdesk == 'delivery') {
                $genset = Genset::find($record->genset_id);
                $genset->status_genset = 'rent';
                $genset->save();
            }
        });
    }
}
