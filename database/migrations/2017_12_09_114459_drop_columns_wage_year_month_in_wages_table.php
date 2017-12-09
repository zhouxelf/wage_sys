<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsWageYearMonthInWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wages', function (Blueprint $table) {
            $table->dropColumn(['wage_year', 'wage_month']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wages', function (Blueprint $table) {
            $table->string('wage_year', 4)->comment('工资年份');
            $table->string('wage_month', 2)->comment('工资月份');
        });
    }
}
