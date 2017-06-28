<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        $admin = new App\Admin();
        $admin->name = 'Admin';
        $admin->email = 'admin@faststardlv.com';
        $admin->password = bcrypt('123456');
        $admin->save();
    }
}
