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
        Schema::create('directors', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->engine    = 'InnoDB';

            $table->id()->comment("Egyedi azonosító");

            $table->string(column : 'name')->comment("A rendező neve");
            $table->integer(column : 'tmdb_id')->unique()->comment("A rendező TMDB ID-ja");
            $table->text(column : 'biography')->nullable()->comment("A rendsző életrajza");
            $table->date(column : 'birth_date')->nullable()->comment("A rendező születési ideje");

            $table->comment("Rendezők nyilvántartása");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directors');
    }
};
