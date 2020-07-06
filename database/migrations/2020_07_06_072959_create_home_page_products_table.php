<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePageProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_page_products', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("product_id");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("restrict");
            $table->enum("product_type", ["product-hot-deal", "product-popular", "product-best-rating"]);
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
        Schema::dropIfExists('home_page_products');
    }
}
