<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $table = 'RESPONSES';
    protected $primary_key = 'id';
    protected $fillable = [
        'answer_id',
        'question_id',
        'answer'
    ];
}
