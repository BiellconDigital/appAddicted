<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    public function up()
    {
        Schema::create('user', function($table)
        {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('photo');
            $table->string('name');
            $table->string('password');
            $table->string('password');
            $table->boolean('inscrito');
            $table->string('form_nombre');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('user');
    }

}