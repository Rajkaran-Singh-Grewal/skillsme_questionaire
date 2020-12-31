<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;
    protected $table = 'QUESTIONNAIRES';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'visibility',
        'viewableuser',
        'user_id',
        'endDate'
    ]
}
