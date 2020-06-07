<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('epc', 50)->unique();
            $table->string('name', 50);
            $table->integer('copy');
            $table->boolean('status')->default(0);
            $table->string('type', 50);
            $table->string('image')->default('tool.png');;
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
        Schema::dropIfExists('tools');
    }
}
