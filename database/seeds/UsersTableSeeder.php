<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $admin = new User();
        $admin->name = 'Maseeh';
        $admin->email = 'maseeh.gulf@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->save();
    }
}
