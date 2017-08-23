<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id'); // city_id
            $table->integer('province_id'); // province_id
            $table->string('type', 100);
            $table->string('name', 100);
            $table->string('postal_code', 100);
            $table->timestamps();
        });
    }

    // [city_id] => 1 [province_id] => 21 [province] => Nanggroe Aceh Darussalam (NAD) [type] => Kabupaten [city_name] => Aceh Barat [postal_code] => 23681

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
