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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('Case_id')->nullable();
            $table->string('Title')->nullable();
            $table->string('Case_type')->nullable();
            $table->string('contender')->nullable();
            $table->string('client_name')->nullable();
            $table->integer('Court_no')->nullable();
            $table->string('Content')->nullable();
            $table->string('Note')->nullable();
            $table->string('Attachment')->nullable();
            $table->string('status')->nullable();
            $table->integer('Lawyer_id')->nullable();
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
        Schema::dropIfExists('cases');
    }
};
