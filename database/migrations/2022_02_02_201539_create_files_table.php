<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            // $table->id();
            $table->string("file_id")->unique();
            $table->primary("file_id");
            $table->string("file_groub");
            $table->foreign("file_groub")
            ->references("id")
            ->on("files_groubs")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->string('name',255);
            $table->string("mime",127);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
