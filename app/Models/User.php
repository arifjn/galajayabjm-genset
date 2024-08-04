<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tempat_lahir',
        'tgl_lahir',
        'no_telp',
        'alamat',
        'status',
        'profile_img',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function canAccessPanel(Panel $panel): bool
    {
        $role = auth()->user()->role;

        return match ($panel->getId()) {
            'admin' => $role === 'admin',
            'operator' => $role === 'operator',
            default => false
        };
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_user');
    }
}
