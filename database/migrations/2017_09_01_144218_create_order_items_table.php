<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->enum('type', array('SHOES', 'UPSELL'));
            // ga tau juga kenapa dibedain name dan display_name
            // mungkin bisa kepake di URL product detail, instead of pake id, pake name
            $table->integer('product_id');
            $table->string('name', 100);
            $table->string('display_name', 100);
            $table->string('colour_name', 100);
            $table->string('details', 500);
            $table->char('currency', 3);
            $table->decimal('price', 11, 2);
            $table->boolean('is_sale');
            $table->decimal('sale_price', 11, 2);
            $table->boolean('is_featured');
            $table->boolean('is_new');
            $table->integer('size_id');
            $table->string('size_metric', '2');
            $table->decimal('size_value', 5, 2);
            $table->integer('count');
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
        Schema::dropIfExists('order_items');
    }
}
