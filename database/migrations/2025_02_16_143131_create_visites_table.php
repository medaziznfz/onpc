<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitesTable extends Migration
{
    public function up()
    {
        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            // Clé étrangère vers la table des certificats (assurez-vous que la table s'appelle "certificats")
            $table->unsignedBigInteger('certificat_id');
            $table->date('date_visite');    // Format : année/mois/jour
            $table->time('heure_visite');   // Format : heure (HH:mm:ss)
            $table->tinyInteger('status')->comment('0: en attente, 1: approuvé, 2: refusé');
            $table->string('remarque')->nullable();
            $table->timestamps();

            // Définir la contrainte de clé étrangère
            $table->foreign('certificat_id')
                  ->references('id')
                  ->on('certificats')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visites');
    }
}
