<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationAccepterTable extends Migration
{
    public function up()
    {
        Schema::create('formation_accepter', function (Blueprint $table) {

            $table->unsignedBigInteger('formation_id');
            $table->unsignedBigInteger('demande_id');
            $table->date('date_prevue');
            $table->timestamps();

            // Définition des clés étrangères
            $table->foreign('formation_id')->references('id')->on('formation')->onDelete('cascade');
            $table->foreign('demande_id')->references('id')->on('demande_formation')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('formation_accepter');
    }
}
