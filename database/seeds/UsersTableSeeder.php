<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('users')->insert([
            'name' => 'Kris',
            'email' => 'kelava91@gmail.com',
            'password' => Hash::make('Ah64pete'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'IP_address' => '74.199.33.166',
        ]);
    }
}
