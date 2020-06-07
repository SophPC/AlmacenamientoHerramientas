<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('place_id', 10);
            $table->string('message', 255);
            $table->string('epcs', 255)->nullable();
            $table->string('employee_id', 10)->nullable();
            $table->string('employee_id_2', 10)->nullable();
            $table->bigInteger('last_event_id')->nullable()->unsigned();
            $table->boolean('employee_status')->nullable();
            $table->string('tool_id', 10)->nullable();
            $table->boolean('tool_status')->nullable();
            $table->timestamps();
            
            // $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('employee_id_2')->references('id')->on('employees');
            $table->foreign('last_event_id')->references('id')->on('events');
            // $table->foreign('employee_status')->references('inORout')->on('events');
            $table->foreign('tool_id')->references('id')->on('tools');
            // $table->foreign('tool_status')->references('status')->on('tools');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidences');
    }
}
