<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments("id");

            $table->unsignedInteger("user_id");
            $table->foreign("user_id")->references("id")->on("Users")->onDelete("cascade");

            $table->text("address_line1");
            $table->text("address_line2");

            $table->unsignedInteger("country_id");
            $table->foreign("country_id")->references("id")->on("countries")->onDelete("restrict");

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
        Schema::dropIfExists('addresses');
    }
}
