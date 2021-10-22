<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class rolesseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'description'=> 'admin'
        ]);
        DB::table('roles')->insert([
            'description'=> 'hr'
        ]);
        DB::table('roles')->insert([
            'description'=> 'employee'
        ]);
        //
    }
}
