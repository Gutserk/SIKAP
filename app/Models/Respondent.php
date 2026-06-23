<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    use HasFactory;

    protected $table = 'responden';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'email',
        'pendidikan',
        'usia',
        'dibuat_pada',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'responden_id');
    }
}
