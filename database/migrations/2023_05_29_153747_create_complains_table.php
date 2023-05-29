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
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('category');
            $table->string('ward');
            $table->string('area')->nullable();
            $table->string('road')->nullable();
            $table->string('house')->nullable();
            $table->text('description');
            $table->string('user_id');
            $table->text('pictures')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complains');
    }
};
