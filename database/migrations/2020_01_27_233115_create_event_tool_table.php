<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventToolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tool', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('event_id')->unsigned();
            $table->string('tool_id', 10);

            // For foreign keys
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('tool_id')->references('id')->on('tools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_tool');
    }
}
