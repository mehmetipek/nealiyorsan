<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrequentlyAskedQuestions extends Model
{
    protected $fillable = [
        'id',
        'question',
        'answer',
        'question_category'
    ];
}
