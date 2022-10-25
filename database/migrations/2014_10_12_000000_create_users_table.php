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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uname')->nullable();
            $table->text('avatar')->nullable();
            $table->text('utype')->nullable();
            $table->text('phone')->nullable();
            $table->string('IDnumber')->nullable();
            $table->tinyInteger('blocked')->default(0)->index();
            $table->dateTimeTz('last_visit')->nullable();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('access_token')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
