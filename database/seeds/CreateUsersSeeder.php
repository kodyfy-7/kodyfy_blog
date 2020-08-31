<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@kodyfy.com',
                'username' => 'admin',
                'is_admin' => '1',
                'admin_role' => '1',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'SubAdmin',
                'email' => 'subadmin@kodyfy.com',
                'username' => 'subadmin',
                'is_admin' => '1',
                'admin_role' => '0',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'User',
                'email' => 'user@kodyfy.com',
                'username' => 'user',
                'is_admin' => '0',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
