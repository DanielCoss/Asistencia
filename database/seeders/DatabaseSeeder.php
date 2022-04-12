<?php

namespace Database\Seeders;

use App\Models\Class_hour;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigurationSeeder::class);
        $this->call(FortnightSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EmployerSeeder::class);
        $this->call(ClassHourSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(QuincenalAssistanceSeeder::class);
    }
}
