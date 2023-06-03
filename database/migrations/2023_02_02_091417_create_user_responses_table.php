<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_form_id')->nullable();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedBigInteger('sub_form_id')->nullable();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->integer('custom_case')->nullable();
            $table->string('question_key')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_id')->nullable();
            $table->string('question_response')->nullable();
            $table->string('additional_comment')->nullable();
            $table->string('additional_info')->nullable();
            $table->string('admin_comment')->nullable();
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
        Schema::dropIfExists('user_responses');
    }
}
