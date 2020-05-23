<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchs', function (Blueprint $table) {
            $table->id();
            $table->integer("idgame");
            $table->integer("sportId");
            $table->string("sportName");
            $table->integer("champId");
            $table->string("champName");
            $table->string("nameGame");
            $table->string("gameTyp");
            $table->integer("opp1");
            $table->integer("opp2");
            $table->integer("ResultPriority");
            $table->integer("clid_opp1")->nullable();
            $table->integer("clid_opp2")->nullable();
            $table->integer("country");
            $table->integer("idbetgames_main");
            $table->integer("opp1Country")->nullable();
            $table->integer("opp2Country")->nullable();
            $table->integer("dopScore")->nullable();
            $table->integer("IdSubGame")->nullable();
            $table->string("date");
            $table->string("add_info");
            $table->string("scores");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matchs');
    }
}
