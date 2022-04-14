<?php

namespace Database\Seeders;

use App\Models\Class_hour;
use App\Models\Classrom;
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
        $this->call(ClassHourSeeder::class);
        $this->call(FortnightSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EmployerSeeder::class);
        $this->call(QuincenalAssistanceSeeder::class);

        $this->call(ScheduleSeeder::class);
        $this->call(ClassromSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(EmployerScheduleSeeder::class);

    }
}
