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
        Schema::create('factions', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('color');
        });

        DB::table('factions')->insert([
            ['label' => 'Inconnue', 'color' => 'purple'],
            ['label' => 'Neutre', 'color' => 'grey'],
            ['label' => 'Impérial', 'color' => 'red'],
            ['label' => 'République', 'color' => 'blue'],
            ['label' => 'Mandalorien', 'color' => 'green'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factions');
    }
};
