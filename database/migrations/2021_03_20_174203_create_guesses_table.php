<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guesses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('round_id');
            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');

            $table->uuid('player_id');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');

            $table->string('track');
            // $table->string('artist');

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
        Schema::dropIfExists('guesses');
    }
}
