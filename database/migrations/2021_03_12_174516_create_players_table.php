<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

            $table->boolean('is_creator')->default(false);

            $table->string('name')->nullable();

            $table->string('spotify_access_token')->nullable();
            $table->string('spotify_token_type')->nullable();
            $table->dateTime('spotify_expires_at')->nullable();
            $table->string('spotify_refresh_token')->nullable();
            $table->string('spotify_scope')->nullable();

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
        Schema::dropIfExists('players');
    }
}
