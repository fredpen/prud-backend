<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMbaPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mba_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId("mba_id")->index();
            $table->string("type")->nullable()->index();
            $table->unsignedBigInteger("cost")->nullable()->index();
            $table->integer("numbers_of_shares_you_get")->default(1)->index();
            $table->integer("tenure_in_months")->default(12)->index();
            $table->integer("roi_in_percentage")->default(23)->index();
            $table->integer("details")->nullable()->index();
            $table->date("start_date")->default(now())->index();
            $table->date("end_date")->default(now()->addMonths(12))->index();
            $table->boolean('isActive')->default(true);
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
        Schema::dropIfExists('mba_plan');
    }
}
