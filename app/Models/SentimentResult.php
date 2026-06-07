<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentimentResult extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'answer_id',
        'sentiment',
        'score',
        'analyzed_at',
    ];

    protected $casts = [
        'analyzed_at' => 'datetime',
        'score' => 'decimal:4',
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
