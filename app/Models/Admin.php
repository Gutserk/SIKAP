<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'kata_sandi',
        'terakhir_masuk_pada',
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    protected $casts = [
        'terakhir_masuk_pada' => 'datetime',
        'kata_sandi' => 'hashed',
    ];

    public function getAuthPassword(): string
    {
        return $this->kata_sandi;
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'admin_id');
    }
}
