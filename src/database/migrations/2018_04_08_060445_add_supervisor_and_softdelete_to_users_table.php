<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupervisorAndSoftdeleteToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasColumn('users', 'supervisor_id')) {
            Schema::table("users", function (Blueprint $table) {
                $table->unsignedInteger('supervisor_id')->nullable();
            });
        }
        if (!Schema::hasColumn('users', 'deleted_at')) {
            Schema::table("users", function (Blueprint $table) {
                $table->softDeletes();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasColumn('users', 'supervisor_id')) {
            Schema::table("users", function (Blueprint $table) {
                $table->dropColumn('supervisor_id');
            });
        }
        if (Schema::hasColumn('users', 'deleted_at')) {
            Schema::table("users", function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
}
