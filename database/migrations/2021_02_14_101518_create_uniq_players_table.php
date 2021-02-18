<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniqPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uniq_players', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer("clid_opp")->nullable();
            $table->integer("id_player")->nullable();
            $table->string('ukname')->nullable();
            $table->string("rating")->nullable();
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
        Schema::dropIfExists('uniq_players');
    }
}
