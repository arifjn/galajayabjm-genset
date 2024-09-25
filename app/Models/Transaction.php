<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',

        'customer_id',
        'genset_id',
        'sales_id',

        'subject',
        'tgl_sewa',
        'tgl_selesai',
        'site',
        'kapasitas',
        'keterangan',
        'status_transaksi',

        'bukti_tf',
        'ppn',
        'harga',
        'mob_demob',
        'biaya_operator',

        'sub_total',
        'grand_total',

        'denda',
    ];

    protected $dates = ['tgl_sewa', 'tgl_selesai'];


    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {
            if ($model->isDirty('bukti_tf') && ($model->getOriginal('bukti_tf') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('bukti_tf'));
            }
        });

        /** @var Model $model */
        static::deleting(function ($model) {
            if ($model->getOriginal('bukti_tf')) {
                Storage::disk('public')->delete($model->getOriginal('bukti_tf'));
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_id', 'id');
    }

    public function genset(): BelongsTo
    {
        return $this->belongsTo(Genset::class);
    }

    public function plan(): HasOne
    {
        return $this->hasOne(Plan::class, 'order_id', 'order_id');
    }
}
