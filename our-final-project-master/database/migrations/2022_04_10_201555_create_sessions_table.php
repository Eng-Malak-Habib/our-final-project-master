<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('Role_no')->nullable();
            $table->string('present_Lawyer_name');
            $table->string('Session_Reason')->nullable();
            $table->string('Session_date')->nullable();
            $table->string('Session_Requirements')->nullable();
            $table->string('Attachment')->nullable();
            $table->string('Next_date')->nullable();
            $table->string('Desicion')->nullable();
            $table->integer('Case_id')->nullable();
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
        Schema::dropIfExists('sessions');
    }
}
