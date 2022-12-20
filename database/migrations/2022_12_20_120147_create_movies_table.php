<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->engine    = 'InnoDB';

            $table->id()->comment("Egyedi azonosító");

            $table->string(column : 'title')->comment("A film címe");
            $table->text(column : 'overview')->comment("Leírás");
            $table->integer(column : 'tmdb_id')->comment("TMDB egyedi azonosító");
            $table->float(column : 'tmdb_average')->comment("TMDB szavazat átlag");
            $table->integer(column : 'tmdb_count')->comment("TMDB szavazatok száma");
            $table->string(column : 'tmdb_url')->comment("TMDB URL");
            $table->bigInteger(column : 'director_id')->unsigned()->comment("A rendező ID");
            $table->string(column : 'poster_url')->nullable()->comment("Borítókép URL");

            $table->timestamps();

            $table->foreign(columns : 'director_id')->references('id')->on('directors')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->comment("Filmek nyilvántartása");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
