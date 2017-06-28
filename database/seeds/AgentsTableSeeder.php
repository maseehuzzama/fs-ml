<?php

use Illuminate\Database\Seeder;

class AgentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->delete();

        $admin = new App\Agent();
        $admin->name = 'Agent';
        $admin->email = 'agent@faststardlv.com';
        $admin->password = bcrypt('123456');
        $admin->save();
    }
}
