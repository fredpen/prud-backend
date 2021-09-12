<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mba_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('plan_name')->nullable();
            $table->integer('num_of_units')->default(1);
            $table->integer('tenure_in_months')->default(12);
            $table->integer('roi_in_percentage')->default(1);
            $table->unsignedBigInteger('amount_paid', 16, 2)->nullable();
            $table->enum('payment_status', [1, 2, 3, 4, 5])->default(1);
            $table->string('payment_description')->default('created');

            $table->dateTime('created_on')->default(now());
            $table->dateTime('payment_confirmed_on')->nullable();
            $table->dateTime('activated_on')->nullable();
            $table->dateTime('closed_on')->nullable();
            $table->dateTime('cancelled_on')->nullable();

            $table->foreign('mba_id')->references('id')->on('mbas');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('plan_id')->references('id')->on('mba_plan');

            $table->softDeletes();
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
        Schema::dropIfExists('investments');
    }
}
