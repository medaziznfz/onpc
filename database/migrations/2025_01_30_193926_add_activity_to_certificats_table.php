<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityToCertificatsTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificats', function (Blueprint $table) {
            $table->string('activity')->nullable();  // Ajoute la colonne 'activity' à la table 'certificats'
        });
    }

    /**
     * Rétablir la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificats', function (Blueprint $table) {
            $table->dropColumn('activity');  // Supprime la colonne 'activity' si la migration est annulée
        });
    }
}
