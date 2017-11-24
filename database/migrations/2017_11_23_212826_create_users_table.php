<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->comment('工号');
            $table->string('name')->comment('姓名');
            $table->string('name_quanpin')->comment('姓名全拼');
            $table->string('name_jianpin')->comment('姓名简拼');
            $table->string('sex')->comment('性别');
            $table->string('phone')->comment('手机号');
            $table->string('salt');
            $table->string('password')->comment('密码');
            $table->tinyInteger('type')->comment('0:普通用户,1:管理员');
            $table->string('status')->comment('状态(0:正常,1:已删除)');
            $table->integer('creator')->comment('创建人');
            $table->integer('updater')->comment('更新人');
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
        Schema::dropIfExists('users');
    }
}
