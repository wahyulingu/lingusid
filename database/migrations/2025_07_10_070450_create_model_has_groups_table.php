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
        Schema::create('model_has_groups', function (Blueprint $table) {
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->morphs('groupable');
            $table->unique(['group_id', 'groupable_id', 'groupable_type'], 'model_has_groups_group_model_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_groups');
    }
};
