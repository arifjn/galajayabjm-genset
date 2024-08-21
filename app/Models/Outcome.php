<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'lainnya',
        'biaya_lainnya',
        'upd',
        'biaya_service',
        'outcome',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
