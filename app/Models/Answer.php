<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'jawaban';

    public $timestamps = false;

    protected $fillable = [
        'pengisian_id',
        'pertanyaan_id',
        'pilihan_id',
        'teks_jawaban',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'pengisian_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'pertanyaan_id');
    }

    public function option()
    {
        return $this->belongsTo(Option::class, 'pilihan_id');
    }

    public function sentimentResult()
    {
        return $this->hasOne(SentimentResult::class, 'jawaban_id');
    }
}
