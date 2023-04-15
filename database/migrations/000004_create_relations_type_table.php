<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('relations_type', function (Blueprint $table) {
            $table->id();
            $table->string('label');
        });

        DB::table('relations_type')->insert([
            ['label' => 'Famille'],
            ['label' => 'Alliés'],
            ['label' => 'Ennemis'],
            ['label' => 'Proches'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relations_type');
    }
};
