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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('record_id')->unique();
            $table->string('topic')->nullable();
            $table->string('Attachment')->nullable();
            $table->string('Note')->nullable();
            $table->string('Client_name')->nullable();
            $table->string('Contender')->nullable();
            $table->integer('Lawyer_id')->nullable();
            $table->integer('Case')->nullable();
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
        Schema::dropIfExists('records');
    }
};
