<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'mbas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->index();
                $table->float('price_per_unit', 10, 2)->index()->default(0);
                $table->integer('available_unit')->index()->default(1);
                // $table->integer('term')->index()->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mbas');
    }
}
