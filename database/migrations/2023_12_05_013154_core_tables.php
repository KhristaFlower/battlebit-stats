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
        Schema::create('players', function (Blueprint $table) {
            $table->id('player_id');
            $table->string('player_name')->unique();
            $table->tinyInteger('player_rank')->unsigned();
            $table->tinyInteger('player_prestige')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('weapon_categories', function (Blueprint $table) {
            $table->id('weapon_category_id');
            $table->string('category_name');
            $table->timestamps();
        });

        Schema::create('weapons', function (Blueprint $table) {
            $table->id('weapon_id');
            $table->string('weapon_name');
            $table->integer('weapon_category_id');
            $table->tinyInteger('weapon_rank')->unsigned();
            $table->timestamps();

            $table->foreign('weapon_category_id')->references('weapon_category_id')->on('weapon_categories');
        });

        Schema::create('player_weapons', function (Blueprint $table) {
            $table->id('player_weapon_id');
            $table->integer('player_id')->unsigned();
            $table->integer('weapon_id')->unsigned();
            $table->integer('kill_count')->unsigned();
            $table->timestamps();

            $table->unique(['player_id', 'weapon_id']);

            $table->foreign('player_id')->references('player_id')->on('players')->cascadeOnDelete();
            $table->foreign('weapon_id')->references('weapon_id')->on('weapons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
