<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('name_fr'); // French name
            $table->string('name_ar'); // Arabic name
            $table->string('image_path'); // Image path
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
