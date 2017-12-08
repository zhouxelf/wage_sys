<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->comment('工号');
            $table->string('name')->comment('姓名');
            $table->string('wage_year', 4)->comment('工资年份');
            $table->string('wage_month', 2)->comment('工资月份');
            $table->float('wage_base')->comment('底薪');
            $table->float('wage_allowance')->comment('津贴');
            $table->float('wage_bonus')->comment('奖金');
            $table->float('wage_should')->comment('应发工资');
            $table->float('water_electric')->comment('水电费');
            $table->float('heating_costs')->comment('暖气费');
            $table->float('house_rent')->comment('房租');
            $table->float('income_tax')->comment('个人所得税');
            $table->float('wage_garnishment')->comment('扣发工资');
            $table->float('wage_actual')->comment('实发工资');
            $table->string('status')->comment('状态(0:正常,1:已删除)');
            $table->integer('creator')->comment('创建人');
            $table->integer('updater')->nullable()->comment('更新人');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wages');
    }
}
