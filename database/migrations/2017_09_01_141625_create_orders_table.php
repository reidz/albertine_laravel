<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('user_first_name', 100);
            $table->string('user_last_name', 100);
            $table->string('user_email', 100);
            $table->char('currency', 3);
            $table->integer('grand_total_qty');
            $table->decimal('grand_total_price', 11, 2);
            $table->decimal('shipping_price', 11, 2);
            $table->decimal('promo_price', 11, 2);
            $table->decimal('grand_total', 11, 2);
            $table->enum('status', array('PAYMENT_CONFIRMATION', 'PAID', 'CANCELLED', 'EXPIRED'));
            $table->string('reason', 500);
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
        Schema::dropIfExists('orders');
    }
}
