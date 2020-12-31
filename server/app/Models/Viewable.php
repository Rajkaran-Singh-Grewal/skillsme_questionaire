<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viewable extends Model
{
    use HasFactory;
    protected $table = 'VIEWABLES';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'questionnaire_id'
    ];
}
