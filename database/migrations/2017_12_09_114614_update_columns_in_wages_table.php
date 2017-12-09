<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsInWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wages', function (Blueprint $table) {
            $table->char('wage_year',4)->after('name')->comment('工资年份');
            $table->char('wage_month',2)->after('wage_year')->comment('工资月份');
            $table->float('wage_base')->default(0)->comment('底薪')->change();
            $table->float('wage_allowance')->default(0)->comment('津贴')->change();
            $table->float('wage_bonus')->default(0)->comment('奖金')->change();
            $table->float('wage_should')->default(0)->comment('应发工资')->change();
            $table->float('water_electric')->default(0)->comment('水电费')->change();
            $table->float('heating_costs')->default(0)->comment('暖气费')->change();
            $table->float('house_rent')->default(0)->comment('房租')->change();
            $table->float('income_tax')->default(0)->comment('个人所得税')->change();
            $table->float('wage_garnishment')->default(0)->comment('扣发工资')->change();
            $table->float('wage_actual')->default(0)->comment('实发工资')->change();
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
            $table->dropColumn(['wage_year', 'wage_month']);
            $table->float('wage_base')->comment('底薪')->change();
            $table->float('wage_allowance')->comment('津贴')->change();
            $table->float('wage_bonus')->comment('奖金')->change();
            $table->float('wage_should')->comment('应发工资')->change();
            $table->float('water_electric')->comment('水电费')->change();
            $table->float('heating_costs')->comment('暖气费')->change();
            $table->float('house_rent')->comment('房租')->change();
            $table->float('income_tax')->comment('个人所得税')->change();
            $table->float('wage_garnishment')->comment('扣发工资')->change();
            $table->float('wage_actual')->comment('实发工资')->change();
        });
    }
}
