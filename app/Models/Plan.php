<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'operator_id',
        'choose_jobdesk',
        'jobdesk',
        'alamat',
        'tanggal_job',
        'tanggal_job_selesai',
        'tanggal_kembali',
        'status',
        'keterangan',
        'nama_supir',
        'nohp_supir',
        'jenis_mobil',
        'plat_mobil',
    ];

    protected $dates = ['tanggal_job_selesai', 'tanggal_job'];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'order_id', 'order_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id', 'id');
    }

    public function gensets(): BelongsToMany
    {
        return $this->belongsToMany(Genset::class)
            ->using(GensetPlan::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'plan_user')
            ->using(PlanUser::class);
    }
}
