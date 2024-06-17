<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Customer extends Authenticable
{
    use Notifiable, HasFactory;

    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'password',
        'tempat_lahir',
        'tgl_lahir',
        'no_telp',
        'alamat',
        'tipe_customer',
        'perusahaan',
        'profile_img',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'tgl_lahir' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {
            if ($model->isDirty('profile_img') && ($model->getOriginal('profile_img') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('profile_img'));
            }
        });

        /** @var Model $model */
        static::deleting(function ($model) {
            if ($model->getOriginal('profile_img')) {
                Storage::disk('public')->delete($model->getOriginal('profile_img'));
            }
        });
    }
}
