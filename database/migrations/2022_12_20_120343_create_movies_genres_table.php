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
        Schema::create('movies_genres', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->engine    = 'InnoDB';

            $table->bigInteger(column : 'movies_id')->unsigned();
            $table->bigInteger(column : 'genres_id')->unsigned();

            $table->unique(columns : ['movies_id', 'genres_id']);

            $table->foreign(columns : 'movies_id')->references('id')->on('movies')->onUpdate('CASCADE')->onDelete(
                'CASCADE'
            );
            $table->foreign(columns : 'genres_id')->references('id')->on('genres')->onUpdate('CASCADE')->onDelete(
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
        Schema::dropIfExists('movies_genres');
    }
};
