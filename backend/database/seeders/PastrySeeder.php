<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PastrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    static $pastries = [
        ["Carne", 17.99, "photo1.jpg"],
        ["Queijo", 7.99, "photo2.jpg"],
        ["Frango", 14.99, "photo3.jpg"],
    ];

    public function run(){
        foreach (self::$pastries as $pastry) {
            DB::table('pastries')->insert([
                'name' => $pastry[0],
                'price' =>  $pastry[1],
                'photo' =>  $pastry[2],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
