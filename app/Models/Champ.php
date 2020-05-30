<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Champ extends Model
{
    protected $fillable = [
        'name'
    ];
    protected $table = 'champs';
}
