<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMbaBenefitsTable extends Migration
{
    public function up()
    {
        Schema::create('mba_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mba_id')->index();
            $table->string('body')->index();
            $table->timestamps();

            $table->foreign('mba_id')->references('id')->on('mbas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mba_benefits');
    }
}
