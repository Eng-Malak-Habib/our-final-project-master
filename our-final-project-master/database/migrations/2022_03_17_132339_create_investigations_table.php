<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investigations', function (Blueprint $table) {
            $table->id();
            $table->string('investigation_id')->unique();
            $table->string('topic')->nullable();
            $table->string('in_Date')->nullable();
            $table->string('contender')->nullable();
            $table->string('client')->nullable();
            $table->string('Decision')->nullable();
            $table->integer('Lawyer_id')->nullable();
            $table->integer('Case_id')->nullable();
            $table->string('Note')->nullable();
            $table->integer('investigation_place_No')->nullable();
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investigations');
    }
};
