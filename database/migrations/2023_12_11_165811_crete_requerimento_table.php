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
        Schema::create('requerimentos', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('id_usuario')->nullable()->constrained('usuarios');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users');
            
            $table->string('titulo');
            $table->string('tipo');
            $table->string('situacao');
            $table->date('data');
            $table->text('descricao');
            
            $table->string('cep', 10);
            $table->string('cidade');
            $table->string('bairro');
            $table->string('logradouro');
    
            $table->text('resposta')->nullable();            
            //$table->foreignId('id_administrador')->nullable()->constrained('administrador');
    
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
        Schema::dropIfExists('requerimentos');
    }
};
