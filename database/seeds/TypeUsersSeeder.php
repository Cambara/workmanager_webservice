<?php

use Illuminate\Database\Seeder;

class TypeUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            'desc' => 'User'
        ]);
        DB::table('user_types')->insert([
            'desc' => 'Admin'
        ]);
    }
}
