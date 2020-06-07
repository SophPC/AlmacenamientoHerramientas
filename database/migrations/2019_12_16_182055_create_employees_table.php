<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('epc', 50)->unique();
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->date('birthdate');
            $table->integer('incidences')->default(0);
            $table->string('department', 50);
            $table->string('image')->default('employee.png');
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
        Schema::dropIfExists('employees');
    }
}
