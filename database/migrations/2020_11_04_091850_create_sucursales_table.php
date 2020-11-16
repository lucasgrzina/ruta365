<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSucursalesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',250)->index();
            $table->string('codigo',100)->nullable()->index();
            $table->unsignedInteger('retail_id')->index();
            $table->text('observaciones')->nullable();
            $table->decimal('target_attach',5,2)->default(0);
            $table->integer('piso_unidades_office')->default(0);
            $table->integer('categoria_cluster')->default(null);
            $table->boolean('enabled')->default(true)->index();
            $table->auditable();
            $table->timestamps();
            $table->softDeletes();
        });

        /*Schema::create('SINGULAR_NAME_translations', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('foreign_id')->unsigned(); //Cambiar por id
            $table->string('locale')->index();

            //$table->string('name')->unique();

            $table->unique(['foreign_id','locale']);
        });*/         

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sucursales');
        //Schema::drop('SINGULAR_NAME_translations'); //Cambiar por nombre de tabla
    }
}
