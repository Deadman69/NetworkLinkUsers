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
        Schema::create('relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('related_person_id');
            $table->unsignedBigInteger('relation_type_id');
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('related_person_id')->references('id')->on('persons');
            $table->foreign('relation_type_id')->references('id')->on('relations_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relations');
    }
};
