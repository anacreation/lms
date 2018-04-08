<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->unsignedInteger('vacancies')->nullable();
            $table->softDeletes();

            // Timestamp
            $table->timestamp('enrollment_start')->nullable();
            $table->timestamp('enrollment_end')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            // boolean
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_featured')->default(false);

            // Relation
            $table->unsignedInteger('permission_id')->nullable();
            $table->string('completion_criteria_type');
            $table->unsignedInteger('completion_criteria_id');

            $table->timestamps();
        });

        Schema::create('collection_lesson', function (Blueprint $table) {
            $table->unsignedInteger('collection_id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('order')->default(0);
            $table->foreign('collection_id')->references('id')->on('lessons');
            $table->foreign('lesson_id')->references('id')->on('lessons');
        });

        Schema::create('instructor_lesson', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('lesson_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lesson_id')->references('id')->on('lessons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('instructor_lesson');
        Schema::dropIfExists('collection_lesson');
        Schema::dropIfExists('lessons');
    }
}
