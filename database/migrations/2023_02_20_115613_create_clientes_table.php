<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nome_cliente', 100);
            $table->string('cpf_cnpj_cliente', 20);
            $table->date('dtnascimento_cliente');
            $table->string('email_cliente', 30);
            $table->string('tel1_cliente', 15);
            $table->string('tel2_cliente', 15);
            $table->string('num_cliente', 10);
            $table->unsignedBigInteger('fk_locais_cliente');
            $table->unsignedBigInteger('fk_end_cliente');
            $table->timestamps();

            $table->foreign('fk_locais_cliente')->references('id_local')->on('locais')->onDelete('cascade');
            $table->foreign('fk_end_cliente')->references('id_end')->on('enderecos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
