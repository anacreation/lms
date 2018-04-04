<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrerequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('prerequisites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lesson_id');
            $table->foreign('lesson_id')->references('id')->on('lessons')
                  ->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('prerequisite_requirement', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prerequisite_id');
            $table->unsignedInteger('requirement_id');
            $table->string('requirement_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('prerequisite_requirement');
        Schema::dropIfExists('prerequisites');
    }
}
