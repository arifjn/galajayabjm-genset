<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'genset_id',
        'order_id',
        'user_id',
        'tgl_cek',
        'foto_service',
        'service_report',
        'part_request',
        'check_list',
        'biaya_service',
        'keterangan'
    ];

    protected $casts = [
        'foto_service' => 'array',
    ];

    protected $dates = ['tgl_cek'];

    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {
            // if ($model->isDirty('foto_service') && ($model->getOriginal('foto_service') !== null)) {
            //     Storage::disk('public')->delete($model->getOriginal('foto_service'));
            // }

            $imagesToDelete = array_diff($model->getOriginal('foto_service'), $model->foto_service);
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img);
            }

            if ($model->isDirty('service_report') && ($model->getOriginal('service_report') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('service_report'));
            }

            if ($model->isDirty('part_request') && ($model->getOriginal('part_request') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('part_request'));
            }

            if ($model->isDirty('check_list') && ($model->getOriginal('check_list') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('check_list'));
            }
        });

        /** @var Model $model */
        static::deleting(function ($model) {
            if ($model->getOriginal('foto_service')) {
                Storage::disk('public')->delete($model->getOriginal('foto_service'));
            }

            if ($model->getOriginal('service_report')) {
                Storage::disk('public')->delete($model->getOriginal('service_report'));
            }

            if ($model->getOriginal('part_request')) {
                Storage::disk('public')->delete($model->getOriginal('part_request'));
            }

            if ($model->getOriginal('check_list')) {
                Storage::disk('public')->delete($model->getOriginal('check_list'));
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'service_user');
    }
}
