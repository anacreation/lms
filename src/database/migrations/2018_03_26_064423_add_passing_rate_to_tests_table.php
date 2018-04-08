<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassingRateToTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasColumn('tests', 'passing_rate')) {
            Schema::table("tests", function (Blueprint $table) {
                $table->unsignedDecimal('passing_rate')->default(50.0);
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasColumn('tests', 'passing_rate')) {
            Schema::table("tests", function (Blueprint $table) {
                $table->dropColumn('passing_rate');
            });
        }
    }
}
