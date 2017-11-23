<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->comment('权限节点名');
            $table->string('code')->comment('权限节点编号,如001,01001');
            $table->mediumInteger('pid')->comment('父级节点id');
            $table->string('depth')->comment('菜单层级,一级菜单1,二级菜单2,页面3');
            $table->string('path')->comment('权限节点路径');
            $table->string('type')->comment('节点类型(0:menu,1:button,2:api)');
            $table->string('sort_factor')->comment('排序因子(越小越靠前)');
            $table->string('icon')->comment('菜单图标class名称');
            $table->string('status')->comment('状态(0:正常,1:已删除)');
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
        Schema::dropIfExists('nodes');
    }
}
