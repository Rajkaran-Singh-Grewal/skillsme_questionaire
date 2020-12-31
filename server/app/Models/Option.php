<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $table = 'OPTIONS';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'question_id',
        'title',
        'order'
    ]
}
