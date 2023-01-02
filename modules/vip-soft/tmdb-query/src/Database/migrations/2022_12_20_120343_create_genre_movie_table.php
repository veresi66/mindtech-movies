<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_movie', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->engine    = 'InnoDB';

            $table->bigInteger(column : 'movie_id')->unsigned();
            $table->bigInteger(column : 'genre_id')->unsigned();

            $table->unique(columns : ['movie_id', 'genre_id']);

            $table->foreign(columns : 'movie_id')->references('id')->on('movies')->onUpdate('CASCADE')->onDelete(
                'CASCADE'
            );
            $table->foreign(columns : 'genre_id')->references('id')->on('genres')->onUpdate('CASCADE')->onDelete(
                'CASCADE'
            );

            $table->comment("Filmek - műfajok kapcsoló tábla");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genre_movie');
    }
};
