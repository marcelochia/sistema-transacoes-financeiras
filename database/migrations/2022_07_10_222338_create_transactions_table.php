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
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_id')->constrained('registros');
            $table->date('data');
            $table->time('hora');
            $table->string('banco_origem');
            $table->string('agencia_origem');
            $table->string('conta_origem');
            $table->string('banco_destino');
            $table->string('agencia_destino');
            $table->string('conta_destino');
            $table->decimal('valor', 10, 2, true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacoes');
    }
};
