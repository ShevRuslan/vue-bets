<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $fillable = [
        'date'
    ];
    protected $table = 'dates';
}
