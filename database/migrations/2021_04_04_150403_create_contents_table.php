<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('pais');
            $table->string('tumo');
            $table->string('dora');
            $table->integer('vote_1')->default(0);
            $table->integer('vote_2')->default(0);
            $table->integer('vote_3')->default(0);
            $table->integer('vote_4')->default(0);
            $table->integer('vote_5')->default(0);
            $table->integer('vote_6')->default(0);
            $table->integer('vote_7')->default(0);
            $table->integer('vote_8')->default(0);
            $table->integer('vote_9')->default(0);
            $table->integer('vote_10')->default(0);
            $table->integer('vote_11')->default(0);
            $table->integer('vote_12')->default(0);
            $table->integer('vote_13')->default(0);
            $table->integer('vote_14')->default(0);
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
        Schema::dropIfExists('contents');
    }
}
