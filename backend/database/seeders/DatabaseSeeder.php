<?php

namespace Database\Seeders;

use App\Models\Bogi;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Train;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $user = new User();
    $user->name = 'Naymur Rahman';
    $user->email = 'naymur@example.com';
    $user->password = Hash::make(value: 'abcd1234');
    $user->remember_token = Str::random(10);
    $user->save();

    Station::insert([
      [
        'name' => 'Dhaka',
        'address' => 'Dhaka',
        'lat' => 90.334,
        'lon' => 92.154
      ],
      [
        'name' => 'Dhaka Bimanbondor',
        'address' => 'Dhaka Bimanbondor',
        'lat' => 90.3134,
        'lon' => 92.1254
      ],
      [
        'name' => 'Khulna',
        'address' => 'Khulna',
        'lat' => 90.23134,
        'lon' => 92.31254
      ],
    ]);

    Train::insert([
      [
        'name' => 'Chitra',
        'date' => '2023-06-02',
        'home_station_id' => 1,
        'start_time' => '06:00'
      ],
      [
        'name' => 'Sundarban',
        'date' => '2023-06-02',
        'home_station_id' => 1,
        'start_time' => '12:00'
      ],
    ]);

    $trains = Train::get();

    foreach ($trains as $train) {
      foreach (eticket_bogis() as $bogiitem) {
        $bogi = new Bogi();
        $bogi->name = $bogiitem['name'];
        $bogi->train_id = $train->id;

        $bogi->save();

        for ($i = 1; $i <= 100; $i++) {
          $seat = new Seat();
          $seat->name = $bogi->name . '-' . $i;
          $seat->type = rand(0, 1);
          $seat->bogi_id = $bogi->id;
          $seat->train_id = $train->id;
          $seat->booked = rand(0, 1);

          $seat->save();
        }
      }
    }

    $schedule = new Schedule();
    $schedule->train_id = 1;
    $schedule->station_id = 2;
    $schedule->time = '07:00';
    $schedule->shovon_price = 50;
    $schedule->s_chair_price = 70;
    $schedule->f_chair_price = 80;
    $schedule->save();
  }
}
