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
        Schema::table('weapons', function (Blueprint $table) {
            $table->addColumn('integer', 'display_order', ['unsigned' => true, 'default' => 0]);
        });

        \App\Models\Weapon::all()->each(function (\App\Models\Weapon $weapon) {
            $weapon->display_order = $weapon->weapon_id;
            $weapon->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weapons', function (Blueprint $table) {
            $table->dropColumn('display_order');
        });
    }
};
