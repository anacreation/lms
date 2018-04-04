<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CurriculumUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('curriculum_user', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id');
            $table->foreign('curriculum_id')->references('id')
                  ->on('curricula')
                  ->onDelete('cascade');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->timestamp('due_date')->nullable();
            $table->primary(['curriculum_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('curriculum_user');
    }
}
