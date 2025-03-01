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
    Schema::create('certificats', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Clé étrangère pour lier à l'utilisateur
        $table->timestamps();
        $table->integer('gouvernorat');
        $table->integer('delegation');
        $table->integer('type_activite');
        $table->timestamp('verified_at')->nullable();
        $table->timestamp('expiry_at')->nullable();
        $table->string('hash')->nullable();



        // Clé étrangère
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificats');
    }
};
