<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'genset_id',
        'order_id',
        'operator_id',
        'tgl_cek',
        'foto_rental',
        'daily_report',
        'keterangan'
    ];

    protected $casts = [
        'foto_rental' => 'array',
    ];

    protected $dates = ['tgl_cek'];

    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {

            $imagesToDelete = array_diff($model->getOriginal('foto_rental'), $model->foto_rental);
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img);
            }

            if ($model->isDirty('daily_report') && ($model->getOriginal('daily_report') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('daily_report'));
            }
        });

        /** @var Model $model */
        static::deleting(function ($model) {
            if ($model->getOriginal('foto_rental')) {
                Storage::disk('public')->delete($model->getOriginal('foto_rental'));
            }

            if ($model->getOriginal('daily_report')) {
                Storage::disk('public')->delete($model->getOriginal('daily_report'));
            }
        });
    }

    public function genset(): BelongsTo
    {
        return $this->belongsTo(Genset::class, 'genset_id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'order_id', 'order_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id', 'id');
    }
}
