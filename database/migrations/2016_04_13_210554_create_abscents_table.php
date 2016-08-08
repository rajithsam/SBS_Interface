<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbscentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abscents', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('startDate');
            $table->datetime('endDate');
            $table->integer('leave_id')->unsigned()->nullable();
            $table->foreign('leave_id')->references('id')->on('leaves');
            $table->text('note')->nullable();
            $table->boolean('approved')->default(false);
            $table->integer('approved_by_user')->nullable();
            $table->string('approved_from_ip')->nullable();
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');
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
        Schema::drop('abscents');
    }
}
