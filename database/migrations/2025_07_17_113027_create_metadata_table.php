<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type'); // e.g. 'App\Models\User'
            $table->unsignedBigInteger('entity_id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();

            // Kombinasi unik: key hanya boleh 1x per entity
            $table->unique(['entity_type', 'entity_id', 'key']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata');
    }
};
