<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMbaphotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mba_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url')->index();
            $table->unsignedBigInteger('mba_id')->index();
            $table->timestamps();

            $table->foreign('mba_id')->references('id')->on('mbas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mba_photos');
    }
}
