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
        Schema::create('ciudadanos', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('nacionalidad', ['V', 'E']);
            $table->integer('cedula')->unique();
            $table->string('slug');
            $table->enum('sexo', ['M', 'F']);
            $table->date('nacimiento');
            $table->enum('codigo', ['0416', '0426', '0414', '0424', '0412'])->nullable()->default(null);
            $table->string('telefono')->nullable()->default(null);
            $table->text('direccion');
            $table->unsignedBigInteger('concejo_id');
            $table->unsignedBigInteger('parroquia_id');
            $table->unsignedBigInteger('jefe_id')->nullable();

            $table->foreign('concejo_id')->references('id')->on('concejos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parroquia_id')->references('id')->on('parroquias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jefe_id')->references('id')->on('jefes')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('ciudadanos');
    }
};
