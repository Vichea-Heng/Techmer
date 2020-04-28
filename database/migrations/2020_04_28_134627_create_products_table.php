<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments("id");
            $table->string("title");
            $table->unsignedInteger("brand_id");
            $table->foreign("brand_id")->references("id")->on("product_brands")->onDelete("restrict");


            $table->text("content");
            $table->unsignedInteger("category_id");
            $table->foreign("category_id")->references("id")->on("product_categories")->onDelete("restrict");

            $table->unsignedInteger("posted_by");
            $table->foreign("posted_by")->references("id")->on("users")->onDelete("restrict");

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
        Schema::dropIfExists('products');
    }
}
