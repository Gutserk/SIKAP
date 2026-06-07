<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'gender',
        'email',
        'education',
        'age',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
