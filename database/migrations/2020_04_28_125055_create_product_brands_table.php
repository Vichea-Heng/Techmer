<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_brands', function (Blueprint $table) {
            $table->increments("id");
            $table->string("brand");

            $table->unsignedInteger("from_country");
            $table->foreign("from_country")->references("id")->on("countries")->onDelete("restrict");

            $table->unsignedInteger("posted_by");
            $table->foreign("posted_by")->references("id")->on("Users")->onDelete("restrict");

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
        Schema::dropIfExists('product_brands');
    }
}
