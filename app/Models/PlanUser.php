<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanUser extends Pivot
{
    public static function booted(): void
    {
        static::creating(function ($record) {
            $user = User::find($record->user_id);
            $user->status = 'bertugas';
            $user->save();
        });
    }
}
