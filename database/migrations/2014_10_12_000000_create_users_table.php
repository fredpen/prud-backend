<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('surname')->index();
                $table->string('first_name')->index();
                $table->string('email')->index()->unique();
                $table->string('phone_number')->index()->unique();
                $table->enum('role_id', [1, 2, 3, 4])->index()->default(4);
                $table->string('title')->nullable();
                $table->longText('address')->nullable();
                $table->boolean('isActive')->index()->default(true);
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->float('earnings')->nullable();
                $table->string('avatar', 2048)->nullable();
                $table->string('security_question')->nullable();
                $table->longText('security_answer')->nullable();
                $table->longText('access_code')->nullable();
                $table->timestamps();
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
