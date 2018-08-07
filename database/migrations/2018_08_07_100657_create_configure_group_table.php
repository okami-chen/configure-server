<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigureGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configure_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip',30)->comment('ip地址');
            $table->string('title', 50)->comment('标题');
            $table->string('intro', 200)->comment('描述');
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
        Schema::dropIfExists('configure_group');
    }
}
