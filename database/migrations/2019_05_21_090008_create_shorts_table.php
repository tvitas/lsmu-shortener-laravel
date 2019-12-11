<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shorts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tags', 255)->nullable();
            $table->string('url', 255)->unique();
            $table->string('identifier', 15)->default('');
            $table->datetime('expires')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique('identifier');
            $table->index('url');
            $table->index('identifier');
            $table->index('expires');
            $table->index('tags');
            $table->index('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shorts');
    }
}
