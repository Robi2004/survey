<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = "answers";
    protected $fillable = [
        'id',
        'content',
        'id_question'
    ];

    public function Question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
