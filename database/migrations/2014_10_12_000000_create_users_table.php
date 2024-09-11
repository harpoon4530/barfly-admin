<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('social_id', 50)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 50)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('phone', 13)->nullable();
            $table->string('dob', 20)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('reset_code', 4)->nullable();
            $table->unsignedTinyInteger('is_social')->default('0');
            $table->string('source', 50);
            $table->unsignedTinyInteger('role_id');
            $table->unsignedMediumInteger('bar_id')->default('0');
            $table->timestamp('email_verified_at')->nullable();
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
}
