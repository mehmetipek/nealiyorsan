<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id')->nullable()->default(null);
            $table->unsignedBigInteger('category_id')->default(null)->nullable();
            $table->string('title');
            $table->string('slug');
            $table->unsignedTinyInteger('direction')->default(0); ## 0 => Satış, 1 => Alış
            $table->text('description')->nullable();

            $table->integer('price')->default(0);
            $table->integer('min_price')->default(0);
            $table->integer('max_price')->default(0);
            $table->string('currency', 3)->default('TRY');

            $table->json('category_properties')->nullable();

            $table->boolean('is_draft')->default(true);
            $table->tinyInteger('status')->default(0)->index('category_status'); ## 0 => Onay bekliyor, 1 => Onaylandı, 2 => Değişiklik Bekliyor, 3 => iptal
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('admin_id')
                ->references('id')
                ->on('users');

            $table->index(['user_id', 'is_draft']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctons');
    }
}
