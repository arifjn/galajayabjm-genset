<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;

    protected $casts = [
        'genset_id' => 'array',
        'user_id' => 'array',
    ];

    protected $fillable = [
        'order_id',
        'jobdesk',
        'tanggal_job',
        'tanggal_job_selesai',
        'status',
        'keterangan',
        'nama_supir',
        'nohp_supir',
        'jenis_mobil',
        'plat_mobil',
    ];

    // protected static function booted()
    // {
    //     static::deleting(function (User $user) {
    //         $user->photos()->delete();
    //     });
    // }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'order_id');
    }

    public function gensets(): BelongsToMany
    {
        return $this->belongsToMany(Genset::class)
            ->using(GensetPlan::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(PlanUser::class);
    }
}
