<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePremiosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('retail_id')->index();
            $table->string('imagen_web')->nullable();
            $table->string('imagen_mobile')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('enabled')->default(true)->index();
            $table->auditable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('premios');
    }
}
