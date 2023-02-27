<?php

namespace Database\Seeders;

use App\Models\Bogi;
use App\Models\BogiType;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Train;
use App\Models\TrainList;
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
    $user->is_admin = 1;
    $user->remember_token = Str::random(10);
    $user->save();

    Station::insert([
      [
        'name' => 'Khulna',
        'address' => 'Khulna',
        'lat' => 90.23134,
        'lon' => 92.31254,
        'created_at' => now()
      ],
      [
        'name' => 'Dhaka Bimanbondor',
        'address' => 'Bimanbondor, Dhaka',
        'lat' => 90.3134,
        'lon' => 92.1254,
        'created_at' => now()
      ],
      [
        'name' => 'Dhaka',
        'address' => 'Komlapur, Dhaka',
        'lat' => 90.334,
        'lon' => 92.154,
        'created_at' => now()
      ],
    ]);

    TrainList::insert([
      [
        'train_name' => 'Chitra',
        'off_day' => 'Monday',
        'up_down' => 0,
        'created_at' => now()
      ],
      [
        'train_name' => 'Chitra',
        'off_day' => 'Monday',
        'up_down' => 1,
        'created_at' => now()
      ],
    ]);

    Route::insert([
      [
        'route_id' => 1,
        'station_id' => 1,
        'time_from_prev_station' => '00:00',
        'sl_no' => 1
      ],
      [
        'route_id' => 1,
        'station_id' => 2,
        'time_from_prev_station' => '02:00',
        'sl_no' => 2
      ],
      [
        'route_id' => 1,
        'station_id' => 3,
        'time_from_prev_station' => '00:30',
        'sl_no' => 3
      ],
      [
        'route_id' => 2,
        'station_id' => 3,
        'time_from_prev_station' => '00:00',
        'sl_no' => 1
      ],
      [
        'route_id' => 2,
        'station_id' => 2,
        'time_from_prev_station' => '00:30',
        'sl_no' => 2
      ],
      [
        'route_id' => 2,
        'station_id' => 1,
        'time_from_prev_station' => '02:30',
        'sl_no' => 3
      ],
    ]);

    Train::insert([
      [
        'name' => 'Chitra',
        'journey_date' => '2023-02-22',
        'route_id' => 1,
        'created_at' => now()
      ],
      [
        'name' => 'Chitra',
        'journey_date' => '2023-02-23',
        'route_id' => 2,
        'created_at' => now()
      ],
    ]);

    Schedule::insert([
      [
        'train_id' => 1,
        'from_station_id' => 1,
        'to_station_id' => 2,
        'left_station_at' => '2023-02-22 10:00',
        'reach_destination_at' => '2023-02-22 12:00',
        'shovon_price' => 200,
        'created_at' => now()
      ],
      [
        'train_id' => 1,
        'from_station_id' => 1,
        'to_station_id' => 3,
        'left_station_at' => '2023-02-22 10:00',
        'reach_destination_at' => '2023-02-22 12:30',
        'shovon_price' => 250,
        'created_at' => now()
      ],
      [
        'train_id' => 1,
        'from_station_id' => 2,
        'to_station_id' => 3,
        'left_station_at' => '2023-02-22 12:00',
        'reach_destination_at' => '2023-02-22 12:30',
        'shovon_price' => 50,
        'created_at' => now()
      ],
    ]);

    BogiType::insert([
      [
        'bogi_type_name' => 's_chair',
        'seat_count' => 105
      ],
      [
        'bogi_type_name' => 'ac_s',
        'seat_count' => 75
      ],
    ]);

    $trains = Train::get();

    foreach ($trains as $train) {
      foreach (eticket_bogis() as $bogiitem) {
        $bogi = new Bogi();
        $bogi->bogi_name = $bogiitem['name'];
        $bogi->train_id = $train->id;
        $bogi->bogi_type_id = $bogiitem['bogi_type_id'];

        $bogi->save();

        for ($i = 1; $i <= $bogi->bogi_type->seat_count; $i++) {
          $seat = new Seat();
          $seat->seat_name = $bogi->bogi_name . '-' . $i;
          $seat->bogi_id = $bogi->id;
          $seat->booked = rand(0, 2);

          $seat->save();
        }
      }
    }
  }
}
