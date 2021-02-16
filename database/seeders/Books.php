<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Books extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert(
            [
                [
                    'title' => Str::random(40),
                    'description' => Str::random(70),
                    'shortDescription' => Str::random(100),
                ],
                [
                    'title' => Str::random(40),
                    'description' => Str::random(70),
                    'shortDescription' => Str::random(100),
                ],
                [
                    'title' => Str::random(40),
                    'description' => Str::random(70),
                    'shortDescription' => Str::random(100),
                ],
                [
                    'title' => Str::random(40),
                    'description' => Str::random(70),
                    'shortDescription' => Str::random(100),
                ],
                [
                    'title' => Str::random(40),
                    'description' => Str::random(70),
                    'shortDescription' => Str::random(100),
                ],
                [
                    'title' => Str::random(40),
                    'description' => Str::random(70),
                    'shortDescription' => Str::random(100),
                ],
            ]
        );
    }
}
