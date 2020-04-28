<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identities', function (Blueprint $table) {
            $table->increments("id");

            $table->unsignedInteger("user_id");
            $table->foreign("user_id")->references("id")->on("Users")->onDelete("cascade");

            $table->string("first_name");
            $table->string("last_name");
            $table->timestamp("date_of_birth");

            $table->unsignedInteger("address_id")->nullable();
            $table->foreign("address_id")->references("id")->on("addresses")->onDelete("restrict");

            $table->unsignedInteger("nationality_id")->nullable();
            $table->foreign("nationality_id")->references("id")->on("nationalities")->onDelete("restrict");
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
        Schema::dropIfExists('identities');
    }
}
