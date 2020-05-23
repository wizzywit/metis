<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin_user = [
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=> bcrypt('123456'),
        ];

        Admin::create($admin_user);
    }
}
