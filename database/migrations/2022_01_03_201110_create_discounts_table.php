<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->timestamp('expired_at');
            $table->integer('percent');
            $table->timestamps();
        });

        Schema::create('discount_user', function (Blueprint $table) {
           $table->unsignedBigInteger('discount_id');
           $table->foreign('discount_id')->references('id')->on('discounts')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id');
           $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->primary(['discount_id','user_id']);
        });

        Schema::create('discount_product', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('discounts')->cascadeOnDelete();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->primary(['discount_id','product_id']);
        });

        Schema::create('category_discount', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('discounts')->cascadeOnDelete();

//            $table->unsignedBigInteger('category_id');
//            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
//            $table->primary(['discount_id','category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_user');
        Schema::dropIfExists('discount_product');
//        Schema::dropIfExists('category_discount');
        Schema::dropIfExists('discounts');
    }
}
