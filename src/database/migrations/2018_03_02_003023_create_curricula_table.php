<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('curricula', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('curriculum_learning', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curriculum_id');
            $table->foreign('curriculum_id')->references('id')->on('curricula')
                  ->onDelete('cascade');
            $table->unsignedInteger('learning_id');
            $table->string('learning_type');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('curriculum_learning');
        Schema::dropIfExists('curricula');
    }
}
