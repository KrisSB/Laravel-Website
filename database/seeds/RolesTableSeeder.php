<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Roles')->insert([
            ['title' => 'Administrator',
            'Privileges' => 'pushUpdate:showEdit:showView:pushDelete'],
            ['title' => 'Global Moderator',
            'Privileges' => 'pushUpdate']
        ]);
    }
}
