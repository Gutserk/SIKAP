<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    public $timestamps = false;

    protected $fillable = [
        'survei_id',
        'teks_pertanyaan',
        'tipe_pertanyaan',
        'urutan',
        'wajib_diisi',
        'skala_min',
        'skala_max',
        'skala_min_label',
        'skala_max_label',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survei_id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'pertanyaan_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'pertanyaan_id');
    }
}
