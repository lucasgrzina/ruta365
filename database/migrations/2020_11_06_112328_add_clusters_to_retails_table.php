<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClustersToRetailsTable extends Migration
{
    public function up()
    {
        Schema::table('retails', function (Blueprint $table) {
            $table->char('tipo',1)->default('I')->index()->after('color_hexa');
            $table->decimal('cat_1_target_attach',5,2)->default(0);
            $table->decimal('cat_2_target_attach',5,2)->default(0);
            $table->decimal('cat_3_target_attach',5,2)->default(0);
            $table->decimal('cat_4_target_attach',5,2)->default(0);
            $table->decimal('cat_5_target_attach',5,2)->default(0);
            $table->integer('cat_1_puo')->default(0);
            $table->integer('cat_2_puo')->default(0);
            $table->integer('cat_3_puo')->default(0);
            $table->integer('cat_4_puo')->default(0);
            $table->integer('cat_5_puo')->default(0);
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retails', function (Blueprint $table) {
            $table->dropColumn([
                'tipo',
                'cat_1_target_attach',
                'cat_2_target_attach',
                'cat_3_target_attach',
                'cat_4_target_attach',
                'cat_5_target_attach',
                'cat_1_puo',
                'cat_2_puo',
                'cat_3_puo',
                'cat_4_puo',
                'cat_5_puo',
            ]);
        });        
    }
}
