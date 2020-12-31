<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'QUESTIONS';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'questionnaire_id',
        'title',
        'type',
        'required',
        'order'
    ]
}
