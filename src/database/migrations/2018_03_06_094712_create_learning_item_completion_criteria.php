<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningItemCompletionCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("learning_item_completion", function (Blueprint $table) {
            $table->increments("id");
            $table->string("learning_item_type");
            $table->unsignedInteger("learning_item_id");
            $table->string("completion_criteria_type");
            $table->unsignedInteger("completion_criteria_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("learning_item_completion");
    }
}
