<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = 'ANSWERS';
    protected $primary_key = 'id';
    protected $fillable = [
        'questionnaire_id',
        'oscpu',
        'user_ip'
    ];
}
