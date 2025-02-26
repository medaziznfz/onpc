<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('demande_formation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user'); 
            $table->unsignedBigInteger('gouvernerat');
            $table->unsignedBigInteger('delegation');
            $table->unsignedBigInteger('formation_id'); 
            $table->integer('status')->default(1);
            $table->timestamps();
    
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('demande_formation');
    }
};
