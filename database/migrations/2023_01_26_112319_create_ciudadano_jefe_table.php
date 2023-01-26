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
        Schema::create('ciudadano_jefe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ciudadano_id');
            $table->unsignedBigInteger('jefe_id');

            $table->foreign('ciudadano_id')->references('id')->on('ciudadanos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jefe_id')->references('id')->on('jefes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('ciudadano_jefe');
    }
};
