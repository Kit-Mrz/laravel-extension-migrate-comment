# laravel extension migrate comment

在使用 `php artisan migrate` 执行数据迁移时，原生 laravel Blueprint 并没有提供表注释的方法。因此，拓展了此工具。


使用方式
````php
<?php

use Mrzkit\LaravelExtensionMigrateComment\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('name', 32)->default('')->comment('姓名');
            $table->char('mobile', 11)->default('')->comment('手机');
            $table->string('email', 64)->default('')->comment('邮箱');
            $table->string('password', 255)->default('')->comment('密码');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->index('mobile', 'idx_mobile');
            // 这个就是要添加的表注释
            $table->comment = '管理员';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}

````
