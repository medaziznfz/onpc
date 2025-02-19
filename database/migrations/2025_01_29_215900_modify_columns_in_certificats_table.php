<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('certificats', function (Blueprint $table) {
            // Modifier les colonnes
            $table->integer('gouvernorat')->change();
            $table->integer('delegation')->change();
            $table->integer('type_activite')->change();
        });
    }
    
    public function down()
    {
        Schema::table('certificats', function (Blueprint $table) {
            // Revenir aux types précédents
            $table->string('gouvernorat')->change();
            $table->string('delegation')->change();
            $table->string('type_activite')->change();
        });
    }
    
};
