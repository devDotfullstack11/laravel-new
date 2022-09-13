<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('movies', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->string('thumbnail');
            $table->text('about');
            $table->timestamps();
        });

        Schema::create('show_types', function($table) {
            $table->increments('id'); 
            $table->string('title'); // 2D,3D,IMAX3D
            $table->timestamps();
        });
        Schema::create('movie_show_types', function($table) {
            $table->increments('id');
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('show_type_id')->unsigned();
            $table->foreign('show_type_id')->references('id')->on('show_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('languages', function($table) {
            $table->increments('id'); 
            $table->string('title'); // Hindi,Malayalam,Tamil,Punjabi
            $table->timestamps();
        });

        Schema::create('movie_languages', function($table) {
            $table->increments('id'); 
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('genres', function($table) {
            $table->increments('id'); 
            $table->string('title'); // Hindi,Malayalam,Tamil,Punjabi
            $table->timestamps();
        });

        Schema::create('movie_genres', function($table) {
            $table->increments('id'); 
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('genre_id')->unsigned();
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('casts', function($table) {
            $table->increments('id'); 
            $table->string('name'); // Ranboor Kapoor
            $table->string('image'); // 
            $table->timestamps();
        });

        Schema::create('movie_cast', function($table) {
            $table->increments('id'); 
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('cast_id')->unsigned();
            $table->foreign('cast_id')->references('id')->on('casts')->onDelete('cascade');
            $table->string('character_name'); // Ranbir as Shiva
            $table->timestamps();
        });

        Schema::create('movie_time_slots', function($table) {
            $table->increments('id'); 
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('total_seats');
            $table->enum('is_sold', ['0', '1'])->default(0);
            $table->timestamps();
        });

        Schema::create('seat_types', function($table) {
            $table->increments('id'); 
            $table->string('title'); // VIP/NORMAL
            $table->timestamps();
        });

        Schema::create('pricing', function($table) {
            $table->increments('id');
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('movie_time_slot_id')->unsigned();
            $table->foreign('movie_time_slot_id')->references('id')->on('movie_time_slots')->onDelete('cascade'); 
            $table->integer('seat_type_id')->unsigned();
            $table->foreign('seat_type_id')->references('id')->on('seat_types')->onDelete('cascade');
            $table->integer('movie_show_type_id')->unsigned();
            $table->foreign('movie_show_type_id')->references('id')->on('movie_show_types')->onDelete('cascade');
            $table->integer('price'); //
            $table->timestamps();
        });
        //throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
