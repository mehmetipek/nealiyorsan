<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->default(null);
            $table->string('name');
            $table->string('slug');
            $table->string('type');
            $table->json('static_values')->default(null)->nullable();
            $table->integer('range_start')->default(null)->nullable();
            $table->integer('range_end')->default(null)->nullable();
            $table->string('related')->default(null)->nullable();
            $table->json('related_pluck')->default(null)->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_types');
    }
}
