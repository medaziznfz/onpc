<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('formation', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('prix');
            $table->integer('periode');
            $table->string('document')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation');
    }
};
