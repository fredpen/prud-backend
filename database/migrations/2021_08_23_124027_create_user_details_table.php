<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('bank_name')->index()->nullable();
            $table->string('sort_code')->index()->nullable();
            $table->bigInteger('account_number')->index()->nullable();
            $table->string('account_name')->index()->nullable();

            $table->string('kin_surname')->index()->nullable();
            $table->string('kin_firstname')->index()->nullable();
            $table->string('kin_email')->index()->nullable();
            $table->string('kin_phone')->index()->nullable();
           
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_details');
    }
}
