<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin123',
            'nik'=>800025,
            'roles' => 'Admin',
            'password' => Hash::make('admin123',),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
