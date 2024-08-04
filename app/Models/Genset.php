<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Genset extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_genset',
        'brand_engine',
        'tipe_engine',
        'sn_engine',
        'brand_generator',
        'tipe_generator',
        'sn_generator',
        'kapasitas',
        'tipe_genset',
        'images_genset',
        'spek_genset',
        'status_genset',
    ];

    protected $casts = [
        'images_genset' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {
            if ($model->isDirty('images_genset') && ($model->getOriginal('images_genset') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('images_genset'));
            }

            if ($model->isDirty('spek_genset') && ($model->getOriginal('spek_genset') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('spek_genset'));
            }
        });

        /** @var Model $model */
        static::deleting(function ($model) {
            if ($model->getOriginal('images_genset')) {
                Storage::disk('public')->delete($model->getOriginal('images_genset'));
            }

            if ($model->getOriginal('spek_genset')) {
                Storage::disk('public')->delete($model->getOriginal('spek_genset'));
            }
        });
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'genset_plan');
    }
}
