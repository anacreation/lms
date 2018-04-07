<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('certifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lesson_id')->unllable();
            $table->unsignedInteger('validity_days')->default(0);
            $table->unsignedInteger('type')->default(0);
            $table->boolean('use_custom_certification')->default(false);
            $table->timestamps();
        });

        Schema::create('certification_user', function (Blueprint $table) {
            $table->unsignedInteger('certification_id');
            $table->foreign('certification_id')->references('certifications')
                  ->on('id')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('users')
                  ->on('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('certification_user');
        Schema::dropIfExists('certifications');
    }
}
