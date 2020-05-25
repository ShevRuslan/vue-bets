<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;

class Match extends Model
{

    protected $fillable = [
        "idgame",
        "sportId",
        "sportName",
        "champId",
        "champName",
        "nameGame",
        "gameTyp",
        "opp1",
        "opp2",
        "ResultPriority",
        "clid_opp1",
        "clid_opp2",
        "country",
        "idbetgames_main",
        "opp1Country",
        "opp2Country",
        "dopScore",
        "IdSubGame",
        "date",
        "add_info",
        "scores",
    ];

    protected $table ='matchs';
    
    public function players1()
    {
        return $this->hasMany(Player::class, 'id','opp1');
    }
    public function players2()
    {
        return $this->hasMany(Player::class, 'id','oop2');
    }
}
