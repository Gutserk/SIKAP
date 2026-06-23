<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'survei';

    protected $fillable = [
        'admin_id',
        'judul',
        'deskripsi',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'survei_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'survei_id');
    }
}
