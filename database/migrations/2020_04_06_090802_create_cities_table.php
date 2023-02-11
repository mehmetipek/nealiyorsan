<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('locale_code', 2);
            $table->string('continent_code', 2);
            $table->string('continent_name', 13);
            $table->string('country_iso_code', 2)->nullable();
            $table->string('country_name', 44)->nullable();
            $table->string('subdivision_1_iso_code', 3)->nullable();
            $table->string('subdivision_1_name', 52)->nullable();
            $table->string('subdivision_2_iso_code', 3)->nullable();
            $table->string('subdivision_2_name', 38)->nullable();
            $table->string('city_name', 65)->nullable();
            $table->integer('metro_code')->nullable();
            $table->string('time_zone', 30)->nullable();
            $table->tinyInteger('is_in_european_union', false, true)->default(0);
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
        Schema::dropIfExists('cities');
    }
}
