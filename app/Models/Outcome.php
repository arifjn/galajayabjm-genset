<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Outcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'lainnya',
        'biaya_lainnya',
        'upd',
        'biaya_service',
        'biaya_bbm',
        'bukti_pembayaran',
        'outcome',
    ];

    protected $casts = [
        'bukti_pembayaran' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {

            $imagesToDelete = array_diff($model->getOriginal('bukti_pembayaran'), $model->bukti_pembayaran);
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img);
            }
        });

        /** @var Model $model */
        static::deleting(function ($model) {
            if ($model->getOriginal('bukti_pembayaran')) {
                Storage::disk('public')->delete($model->getOriginal('bukti_pembayaran'));
            }
        });
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
