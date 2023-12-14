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
        Schema::create('arquivos', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('id_requerimento')->nullable()->constrained('requerimentos');
            $table->unsignedBigInteger('id_requerimento')->nullable();
            $table->foreign('id_requerimento')->references('id')->on('requerimentos');
            
            $table->string('nome');
            $table->binary('dados');
    
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
        Schema::dropIfExists('arquivos');
    }
};
