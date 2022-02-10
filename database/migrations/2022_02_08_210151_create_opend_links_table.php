<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpendLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opend_links', function (Blueprint $table) {
            $table->id();
            $table->string("groub_id")->nullable();
            $table->foreign("groub_id")
            ->references("groub_id")
            ->on("files_groubs")
            ->onDelete("set null");
            $table->string('country', 20)->nullable();
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
        Schema::dropIfExists('opend_links');
    }
}
