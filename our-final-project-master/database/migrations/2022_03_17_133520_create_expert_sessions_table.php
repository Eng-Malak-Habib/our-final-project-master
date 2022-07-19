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
        Schema::create('expert_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('present_Lawyer_name')->nullable();
            $table->string('Expert_name')->nullable();
            $table->string('Session_Reason')->nullable();
            $table->string('Session_date')->nullable();
            $table->string('Office_address')->nullable();
            $table->string('Attachment')->nullable();
            $table->string('Desicion')->nullable();
            $table->string('Next_date')->nullable();
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
        Schema::dropIfExists('expert_sessions');
    }
};
