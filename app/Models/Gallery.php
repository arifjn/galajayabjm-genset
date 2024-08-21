<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {

            $imagesToDelete = array_diff($model->getOriginal('images'), $model->images);
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img);
            }
        });

        /** @var Model $model */
        static::deleting(function ($model) {
            if ($model->getOriginal('images')) {
                Storage::disk('public')->delete($model->getOriginal('images'));
            }
        });
    }
}
