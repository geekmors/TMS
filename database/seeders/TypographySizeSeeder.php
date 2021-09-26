<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TypographySizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('typography_size')->insert([
            'description'=>'extra-small'
        ]);
        
        DB::table('typography_size')->insert([
            'description'=>'small'
        ]);
        DB::table('typography_size')->insert([
            'description'=>'medium'
        ]);
        DB::table('typography_size')->insert([
            'description'=>'large'
        ]);
        
        DB::table('typography_size')->insert([
            'description'=>'extra-large'
        ]);
        
        
        
        //
    }
}
