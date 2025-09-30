<?php

namespace Database\Seeders;

//use App\Models\User;
use App\Models\User;
use App\Models\Specialist;
use App\Models\Service;
//use App\Models\Appointment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory(1)->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
	    //]);
	User::factory(1)->create();
 // Create services
        $services = Service::factory(4)->create();

        // Create specialists and attach services
        $specialists = Specialist::factory(10)->create()->each(function ($specialist) use ($services) {
            $specialist->services()->attach(
                $services->random(rand(1, 4))->pluck('id')->toArray()
            );
        });

        // Create appointments
       // Appointment::factory(30)->make()->each(function ($appointment) use ($specialists, $services) {
          //  $appointment->specialist_id = $specialists->random()->id;
            //$appointment->service_id    = $services->random()->id;
            //$appointment->save();
        //});	
    }
}
