<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('competencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('competency_requirement', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('competency_id');
            $table->foreign('competency_id')->references('id')
                  ->on('competencies')->onDelete('cascade');
            $table->unsignedInteger('requirement_id');
            $table->unsignedInteger('requirement_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('competency_requirement');
        Schema::dropIfExists('competencies');
    }
}
