<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('address', 100);
            $table->integer('city_id');
            $table->string('city_name', 100);
            $table->integer('province_id');
            $table->string('province_name', 100);
            $table->integer('subdistrict_id');
            $table->string('subdistrict_name', 100);
            $table->string('postal_code', 100);
            $table->string('phone', 100);
            $table->string('service', 100);
            $table->string('description', 100);
            $table->char('currency', 3);
            $table->string('etd', 100);
            $table->string('note', 100);
            $table->integer('total_weight');
            $table->string('receipt_no', 100);
            $table->string('receipt_note', 500);
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
        Schema::dropIfExists('order_shippings');
    }
}
