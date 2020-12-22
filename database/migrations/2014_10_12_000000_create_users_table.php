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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image');
            $table->string('role', 10);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'name' => 'zul fauzi',
                'email' => 'zulfauzi@gmail.com',
                'password' => Hash::make('password123'),
                'image' => 'N/A',
                'role' => 'admin'
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'enterprise',
                'email' => 'enterprise@gmail.com',
                'password' => Hash::make('password123'),
                'image' => 'N/A',
                'role' => 'admin'
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'gilangtaufiq',
                'email' => 'gilang@gmail.com',
                'password' => Hash::make('password123'),
                'image' => 'N/A',
                'role' => 'admin'
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'gedekresna',
                'email' => 'kresna@gmail.com',
                'password' => Hash::make('password123'),
                'image' => 'N/A',
                'role' => 'admin'
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'shabrina',
                'email' => 'shabrina@gmail.com',
                'password' => Hash::make('password123'),
                'image' => 'N/A',
                'role' => 'admin'
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'belindaanindya',
                'email' => 'belinda@gmail.com',
                'password' => Hash::make('password123'),
                'image' => 'N/A',
                'role' => 'admin'
            )
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
