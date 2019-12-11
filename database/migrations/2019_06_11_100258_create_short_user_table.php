<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('short_id')->unsigned();
            $table->biginteger('user_id')->unsigned();

            $table->index('short_id');
            $table->index('user_id');

            $table->foreign('short_id')
                ->references('id')
                ->on('shorts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_user');
    }
}
