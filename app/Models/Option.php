<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $table = 'pilihan';

    public $timestamps = false;

    protected $fillable = [
        'pertanyaan_id',
        'teks_pilihan',
        'urutan',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'pertanyaan_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'pilihan_id');
    }
}
