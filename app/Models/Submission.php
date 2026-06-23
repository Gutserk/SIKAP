<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $table = 'pengisian';

    public $timestamps = false;

    protected $fillable = [
        'responden_id',
        'survei_id',
        'dikirim_pada',
    ];

    protected $casts = [
        'dikirim_pada' => 'datetime',
    ];

    public function respondent()
    {
        return $this->belongsTo(Respondent::class, 'responden_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survei_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'pengisian_id');
    }
}
