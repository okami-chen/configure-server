<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigureNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configure_node', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('version_id', 20);
            $table->unsignedBigInteger('group_id');
            
            $table->string('skey', 50);
            $table->string('svalue', 2000);
            $table->string('remark', 50)->nullable();
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
        Schema::dropIfExists('configure_node');
    }
}
