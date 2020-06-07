|<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('employee_id', 10);
            // $table->string('tool_id', 10)->nullable();
            $table->string('place_id', 10);
            $table->boolean('inORout');
            $table->timestamps();

            // For foreign keys
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            // $table->foreign('tool_id')->references('id')->on('tools')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
