<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniquePlayer extends Model
{
    protected $fillable = [
        'name',
        'clid_opp'
    ];
    protected $table = 'uniq_players';
}
