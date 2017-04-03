<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_business')->length(10)->unsigned()->nullable();
            $table->foreign('fk_business')->references('id')->on('businesses')->onDelete('cascade');
            $table->integer('fk_user')->length(10)->unsigned()->nullable();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('time_begin');
            $table->dateTime('time_end');
            $table->timestamp('time_lunch');
            $table->text('tasks');
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
        Schema::dropIfExists('work_tables');
    }
}
