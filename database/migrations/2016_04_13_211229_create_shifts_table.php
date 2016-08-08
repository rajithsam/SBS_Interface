<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->boolean('Saturday');
            $table->DateTime('StartSaturday')->nullable();
            $table->DateTime('EndSaturday')->nullable();

            $table->boolean('Sunday');
            $table->DateTime('StartSunday')->nullable();
            $table->DateTime('EndSunday')->nullable();

            $table->boolean('Monday');
            $table->DateTime('StartMonday')->nullable();
            $table->DateTime('EndMonday')->nullable();

            $table->boolean('Tuseday');
            $table->DateTime('StartTuseday')->nullable();
            $table->DateTime('EndTuseday')->nullable();

            $table->boolean('Wednesday');
            $table->DateTime('StartWednesday')->nullable();
            $table->DateTime('EndWednesday')->nullable();

            $table->boolean('Thursday');
            $table->DateTime('StartThursday')->nullable();
            $table->DateTime('EndThursday')->nullable();

            $table->boolean('Friday');
            $table->DateTime('StartFriday')->nullable();
            $table->DateTime('EndFriday')->nullable();

            $table->integer('lateArrival');
            $table->integer('earlyDeparture');

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
        Schema::drop('shifts');
    }
}
