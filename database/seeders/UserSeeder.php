<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User();
        $u->name = "Administrador";
        $u->email = "amin@admin.com";
        $u->password = '$2y$10$YS4lARdWL91E/90IPDp6euQDW1C3.3XZV1T6vZcc9DfqyApj.WTTS';
        $u->save();
    }
}
