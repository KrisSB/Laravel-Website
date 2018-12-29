<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'role_id' => '1',
            'user_id' => '1',
            'wiki_id' => NULL,
        ]);
    }
}
