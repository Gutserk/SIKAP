<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentimentResult extends Model
{
    use HasFactory;

    protected $table = 'hasil_sentimen';

    public $timestamps = false;

    protected $fillable = [
        'jawaban_id',
        'sentimen',
        'skor',
        'dianalisis_pada',
    ];

    protected $casts = [
        'dianalisis_pada' => 'datetime',
        'skor' => 'decimal:4',
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'jawaban_id');
    }
}
