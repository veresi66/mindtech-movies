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
        Schema::create('movies', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->engine    = 'InnoDB';
            
            $table->id()->comment("Egyedi azonosító");
            
            $table->string(column : 'title')->comment("A film címe");
            $table->text(column : 'overview')->comment("Leírás");
            $table->integer(column : 'length')->nullable()->comment("A film hossza");
            $table->integer(column : 'tmdb_id')->unique()->comment("TMDB egyedi azonosító");
            $table->integer(column : 'tmdb_order')->comment("TMDB helyezés");
            $table->float(column : 'tmdb_average')->comment("TMDB szavazat átlag");
            $table->integer(column : 'tmdb_count')->comment("TMDB szavazatok száma");
            $table->string(column : 'tmdb_url')->comment("TMDB URL");
            $table->bigInteger(column : 'director_id')->unsigned()->comment("A rendező ID");
            $table->foreign(columns : 'director_id')->references('id')->on('directors')->onDelete('restrict');
            $table->string(column : 'poster_url')->nullable()->comment("Borítókép URL");
            $table->string(column : 'hash')->comment("Az adatok hash értéke");
            $table->timestamps();
            $table->softDeletes();
            
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
