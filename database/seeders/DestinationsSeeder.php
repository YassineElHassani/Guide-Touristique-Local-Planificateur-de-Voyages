<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DestinationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('destinations')->insert([
            'name' => Str::random(length: 10),
            'description' => Str::random(length: 40),
            'address' => Str::random(length: 20),
            'category' => Str::random(length: 8),
            'coordinates' => Str::random(length: 10),
        ]);
    }
}
