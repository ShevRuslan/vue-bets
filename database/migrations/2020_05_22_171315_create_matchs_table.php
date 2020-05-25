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
            $table->integer("idgame")->nullable();
            $table->integer("sportId")->nullable();
            $table->string("sportName")->nullable();
            $table->integer("champId")->nullable();
            $table->string("champName")->nullable();
            $table->string("nameGame")->nullable();
            $table->string("gameTyp")->nullable();
            $table->integer("opp1")->nullable();
            $table->integer("opp2")->nullable();
            $table->integer("ResultPriority")->nullable();
            $table->integer("clid_opp1")->nullable();
            $table->integer("clid_opp2")->nullable();
            $table->integer("country")->nullable();
            $table->integer("idbetgames_main")->nullable();
            $table->integer("opp1Country")->nullable();
            $table->integer("opp2Country")->nullable();
            $table->integer("dopScore")->nullable();
            $table->integer("IdSubGame")->nullable();
            $table->string("date")->nullable();
            $table->string("add_info")->nullable();
            $table->string("scores")->nullable();
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
