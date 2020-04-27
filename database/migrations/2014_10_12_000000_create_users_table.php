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
            $table->increments("id");
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->boolean('email_verified')->nullable()->default(0);
            $table->string('phone_number')->unique();
            $table->boolean('phone_verified')->nullable()->default(0);
            $table->string('password');
            $table->boolean("status")->default(true);
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
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
