<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $categories = [
                'Flying',
                'Lasers',
                'Strength',
                'Technical',
                'Enhanced',
                'Space',
                'Cape',
                'Animal',
                'Magic',
                'Teleportation',
                'Not Human',
                'Computers',

            ];

            foreach ($categories as $category) {
                DB::table('categories')->insert([
                    'name' => $category,
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // You can remove the data if needed, but this isn't necessary for your use case.
    }
}
