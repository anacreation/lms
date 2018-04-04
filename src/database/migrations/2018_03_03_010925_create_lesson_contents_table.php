<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lesson_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->default(0);
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('content_id');
            $table->string('content_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('lesson_contents');
    }
}
