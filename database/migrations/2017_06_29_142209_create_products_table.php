<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('category_id');
            $table->enum('type', array('SHOES', 'UPSELL'));
            // ga tau juga kenapa dibedain name dan display_name
            // mungkin bisa kepake di URL product detail, instead of pake id, pake name
            $table->string('name', 100);
            $table->string('display_name', 100);
            $table->char('currency', 3);
            $table->decimal('amount', 11, 2);
            $table->boolean('is_sale');
            $table->decimal('sale_amount', 11, 2);
            $table->boolean('is_featured');
            $table->tinyInteger('stock');
            $table->tinyInteger('stock_sold');
            $table->tinyInteger('stock_held');
            $table->enum('status', array('READY_STOCK', 'OUT_OF_STOCK', 'INACTIVE'));
            $table->string('created_by', 100);
            $table->string('updated_by', 100);
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
        Schema::dropIfExists('products');
    }
}
