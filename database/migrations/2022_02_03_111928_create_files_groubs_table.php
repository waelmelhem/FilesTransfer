<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesGroubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_groubs', function (Blueprint $table) {
            $table->string("id");
            $table->primary('id');
            $table->string("title")->nullable();
            $table->string('password')->nullable();;
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")
            ->references("id")
            ->on("users")
            ->onDelete("restrict")
            ->onUpdate("restrict");
            $table->string("message",1000)->nullable();;
            $table->date('expire_date');
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
        Schema::dropIfExists('files_groubs');
    }
}
