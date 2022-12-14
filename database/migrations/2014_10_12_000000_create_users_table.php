<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('account_name')->comment('アカウント名');
            $table->string('name')->comment('ユーザー名');
            $table->string('image_icon',191)->nullable()->default(NULL)->comment('アイコン画像');
            $table->string('email',191)->charset("utf8");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',128);
            $table->rememberToken();
            $table->timestamps();
            $table->string('self_introduction')->nullable()->default(NULL)->comment('自己紹介');
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
